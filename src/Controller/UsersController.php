<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Validation\Validator;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['view', 'add', 'logout']);
    }

    public function isAuthorized($user = null)
    {
        if (parent::isAuthorized($user)) { return true; }
        
        // can edit and delete himself
        if ($this->request->action == 'edit' || $this->request->action == 'delete') {
            $requested_id = $this->request->params['pass'][0];
            if ($requested_id == $user['id']) {
                return true;
            }
        }
        return false;
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                // sysadmin is redirected to admin view
                if ($this->App->isSysadmin($user['id'])) {
                    return $this->redirect(['controller' => 'Instances', 'action' => 'index']);
                }
                // admin and users are redirected to home
                return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        $user = $this->Auth->user();
        $this->Auth->logout();
        return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
    }

    public function add()
    {
        # load instance data
        $admin_instance = $this->App->getInstance($this->App->getAdminNamespace());

        // register on Users and register on InstanceUsers

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            // INSERT INTO users (name, email, password, genre_id, created, modified) VALUES
            // ('sysadmin', 'sysadmin@gmail.com', '$2y$10$BjQYV9JwM.IWPmykYbUnF.4H7RgJ49QAemYKeFQ0h65RKO.TbA/sS', 1, '2016-08-01 12:00:00', '2016-08-01 12:00:00'),

            // INSERT INTO instances_users (instance_id, user_id, role_id, contact, main_organization, organization_type_id) VALUES
            // (1, 1, 1, 'sysadmin.contact@ing.uchile.cl', '[null]', 1),

            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Hello ') . $user->name);

                // log the current user out!
                $logged_user = $this->Auth->user();
                if ($logged_user) { $this->Auth->logout(); }

                // log the new user in
                $this->Auth->setUser($user->toArray());
                return $this->redirect(['controller' => 'Users', 'action' => 'home']);
            } else {
                $this->Flash->error(__('There was an error while trying to create this user.'));
                // return $this->redirect(['controller' => 'Users', 'action' => 'add']);
            }
        }
        $genres = $this->Users->Genres
            ->find('list', ['limit' => 200])
            ->where(['Genres.name !=' => '[null]'])
            ->order(['name' => 'ASC']);

        // $organizationTypes = $this->Users->OrganizationTypes
        //     ->find('list', ['limit' => 200])
        //     ->where(['OrganizationTypes.name !=' => '[null]'])
        //     ->where(['OrganizationTypes.instance_id' => $instance->id])
        //     ->order(['name' => 'ASC']);

        // $this->set('instance_namespace', $instance_namespace);
        // $this->set('instance_logo', $instance->logo);
        // $this->set('instance_name', $instance->name);
        $this->set(compact('user', 'genres'));
        $this->set('_serialize', ['user']);
    }

    public function view($id = null)
    {
        // retrieve required user data
        $user = $this->Users->find()
            ->where(['Users.id' => $id])
            ->select(['id','name','email','genre_id'])
            ->select($this->Users->Genres)
            ->contain([
                'Genres',
                'Projects',
                'Instances' => function ($q) {
                    return $q->select(['id', 'name', 'namespace', 'logo']);
                }
            ])
            ->first();
        if (!$user) {
            $this->Flash->error(__('This user does not exists'));
            return $this->redirect($this->referer());
        }

        // --  add remaining info --
        // contact
        $data = $this->App->getUserInstanceData($user->id, $this->App->getAdminInstanceId());
        if ($data) {
            $user->contact = $user->instances[0]->_joinData->contact;
        }
        // organization_type
        foreach ($user->instances as $idx => $instance) {
            $organization_type_id = $instance->_joinData->organization_type_id;
            $user->instances[$idx]->_joinData->organization_type = 
                $this->App->getOrganizationTypeById($instance->id, $organization_type_id);
        }

        // manage access by client
        $auth_client = $this->Auth->user();
        if ($auth_client) {
            // client is a logged in user
            $client_id = $auth_client['id'];
            if ($client_id == $user->id || $this->App->isSysadmin($client_id)) {
                $this->set('client_type', 'authorized');
            } else {
                $this->set('client_type', 'logged');
            }
            $this->set('client_id', $client_id);

        } else {
            // common client
            $this->set('client_type', 'visita');
        }
        // var_dump($user->instances);
        $this->set('user', $user);
    }


    public function edit($id = null)
    {
        $user = $this->Users->find()
            ->where(['id' => $id])
            ->first();
        if (!$user) {
            $this->Flash->error(__('Invalid user'));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            // role management
            if (array_key_exists('grant', $this->request->data)) {
                $grant = $this->request->data["grant"];

                if ($grant >= 0 && $grant <= 2) {

                    // prevent leaving no users of a single type
                    $curr_role = $user->role_id;
                    $remaining = $this->Users->find()
                        ->where([
                            'instance_id' => $instance->id,
                            'role_id' => $curr_role
                        ])
                        ->count();

                    if ($curr_role == 2 && $remaining == 1) {
                        $this->Flash->error(__('Could not revoke user privileges. At least there must exist one sysadmin.'));
                        return $this->redirect($this->referer());
                    }
                    if ($curr_role == 1 && $remaining == 1) {
                        $this->Flash->error(__('Could not revoke user privileges. At least there must exist one admin for this instance.'));
                        return $this->redirect($this->referer());
                    }

                    // modify
                    $user->role_id = $grant;
                    if ($this->Users->save($user)) {
                        if ($grant == 0) {
                            $this->Flash->success(__('Admin privileges were revoked'));
                        } else if ($grant == 1) {
                            $this->Flash->success(__('Admin privileges were granted'));
                        } else {
                            $this->Flash->success(__('Granted Sysadmin privileges'));
                        }

                    } else {
                        $this->Flash->error(__('Could not modify user privileges.'));
                    }
                }
                return $this->redirect($this->referer());
            }
            
            // $user = $this->Users->patchEntity($user, $this->request->data);
            // if ($this->Users->save($user)) {
            //     $this->Flash->success(__('The user has been saved.'));
            //     return $this->redirect(['action' => 'index']);
            // } else {
            //     $this->Flash->error(__('The user could not be saved. Please, try again.'));
            //     return $this->redirect(['action' => 'index']);
            // }
        }

        // if this user is a sysadmin, then, show contact information
        if ($this->App->isSysadmin($id)) {
            $data = $this->App->getUserInstanceData($id, $this->App->getAdminInstanceId());
            if ($data) {
                $user->contact = $data->contact;
                $user->main_organization = $data->main_organization;
            }
        }
    
        $genres = $this->Users->Genres
            ->find('list', ['limit' => 200])
            ->where(['Genres.name !=' => '[null]'])
            ->order(['name' => 'ASC']);

        $this->set(compact('user', 'genres'));
        $this->set('_serialize', ['user']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $logged_user = $this->Auth->user();

        // delete user
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        // redirect to view when deleting by admin, preview otherwise
        $this->Auth->logout();
        if($logged_user['id'] != $user->id) {
            $view_url = Router::url(['controller' => 'Instances', 'action' => 'home', '_full' => true]);
            $this->redirect($view_url);
        } else {
            $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }
    }
}
