<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Event\Event;

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
        if (parent::isAuthorized($user)) {
            return true;
        }
        
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

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $instance_namespace = null)
    {
        // check sys cosas
        if ($instance_namespace) {

            $user = $this->Users->find()
                ->where(['Users.id' => $id])
                ->select(['id','name','email','genre_id'])
                ->select($this->Users->Genres)
                ->contain([
                    'Genres',
                    'Projects',
                    'Instances' => function ($q) use ($instance_namespace) {
                        return $q
                            ->select(['id', 'name', 'namespace', 'logo'])
                            ->where(['Instances.namespace' => $instance_namespace]);
                    }
                ])
                ->first();            
            if (!$user || empty($user->instances)) {
                $this->Flash->error(__('Invalid user'));
                return $this->redirect($this->referer());
            }
            // var_dump($user);


            $owner_id = $user->id;
            $client  = $this->Auth->user();
            $client_id   = $client['id'];

            $data = $this->App->getUserInstanceData($owner_id, $this->App->getAdminInstanceId());
            if ($data) {
                $user->contact = $user->instances[0]->_joinData->contact;
                $user->main_organization = $user->instances[0]->_joinData->main_organization;
            }
        
            // client has auth to view private data:
            $this->set('is_authorized', false);
            if ($client_id == $owner_id || $this->App->isSysadmin($client_id)) {
                $this->set('is_authorized', true);
            }

            $this->set('instance', $user->instances[0]);
            $this->set('user', $user);
            $this->set('view_instance_version', true);
            // $this->set('_serialize', ['user']);
        
        } else {
            
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
                $this->Flash->error(__('Invalid user'));
                return $this->redirect($this->referer());
            }

            $owner_id = $user->id;
            $client  = $this->Auth->user();
            $client_id   = $client['id'];

            // if this user is a sysadmin, then, show contact information
            if ($this->App->isSysadmin($owner_id)) {
                $data = $this->App->getUserInstanceData($owner_id, $this->App->getAdminInstanceId());
                if ($data) {
                    $user->contact = $data->contact;
                    $user->main_organization = $data->main_organization;
                }
            }

            // client has auth to view private data:
            $this->set('is_authorized', false);
            if ($client_id == $owner_id || $this->App->isSysadmin($client_id)) {
                $this->set('is_authorized', true);
            }

            $this->set('user', $user);
            $this->set('view_instance_version', false);
            // $this->set('_serialize', ['user']);
        }

    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        # load instance data
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            # NO ES ATÓMICO!
            $last_id = $this->Users
                ->find()
                ->select(['id'])
                ->order(['id' =>'DESC'])
                ->first()->id;
            #var_dump($last_id);

            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->instance_id = $instance->id;
            $user->id = $last_id + 1;
            $user->role_id = 0;

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                // log the current user out!
                $logged_user = $this->Auth->user();
                if ($logged_user) {
                    $this->Auth->logout();
                }

                // log the new user in
                $this->Auth->setUser($user->toArray());
            
            } else {
                $this->Flash->error(__('There was an error while trying to create this user.'));
            }
            return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
        }
        $genres = $this->Users->Genres
            ->find('list', ['limit' => 200])
            ->where(['Genres.name !=' => '[null]'])
            ->order(['name' => 'ASC']);

        $organizationTypes = $this->Users->OrganizationTypes
            ->find('list', ['limit' => 200])
            ->where(['OrganizationTypes.name !=' => '[null]'])
            ->where(['OrganizationTypes.instance_id' => $instance->id])
            ->order(['name' => 'ASC']);

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set('instance_name', $instance->name);
        $this->set(compact('user', 'genres', 'organizationTypes'));
        $this->set('_serialize', ['user']);

    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
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

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
