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
        
        // All registered users can add projects to their instance!
        if ($this->request->action == 'edit' || $this->request->action == 'delete') {

            // real ns
            $instance_namespace = TableRegistry::get('Instances')
                ->find()
                ->select(['id', 'namespace'])
                ->where(['id' => $user['instance_id']])
                ->first()
                ->namespace;

            // url namespace
            $url_namespace = $this->request->params['pass'][0];
            $requested_id = $this->request->params['pass'][1];

            // same namespace
            if ($url_namespace == $instance_namespace) {
                return true;
            }
        }
        return false;
    }

    public function login($instance_namespace = null)
    {
        if ($instance_namespace && 
            $instance_namespace != "sys" &&
            $instance_namespace != "admin")
        {
            $instance = TableRegistry::get('Instances')
                ->find()
                ->select(['id', 'name', 'namespace', 'logo'])
                ->where(['Instances.namespace' => $instance_namespace])
                ->first();
            if (!$instance) {
                // $this->Flash->error(__('Invalid instance'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }
            $this->set('instance_namespace', $instance_namespace);
            $this->set('instance_logo', $instance->logo);
        }
        

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                // sysadmin is redirected to admin view
                if ($user['role_id'] == '2') {
                    return $this->redirect(['controller' => 'Instances', 'action' => 'index']);
                }

                // admin is redirected to instance admin view
                if ($user['role_id'] == '1') {
                    return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
                }

                // users to instance preview
                return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout($instance_namespace = null)
    {
        $user = $this->Auth->user();
        $this->Auth->logout();

        // redirect repends on user
        if ($user) {
            
            // sysadmin is redirected to home
            if ($user['role_id'] == '2') {
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }

            // admin and user are redirected to instance preview
            return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
        }
        // other
        return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($instance_namespace = null, $id = null)
    {
        // check sys cosas

        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $instance_id = $instance->id;

        $user = $this->Users->find()
            ->where(['Users.instance_id' => 0])
            ->orWhere(['Users.instance_id' => $instance->id])
            ->andWhere(['Users.id' => $id])
            ->select([
                    'id',
                    'name',
                    'email',
                    'contact',
                    'genre_id',
                    'main_organization',
                    'organization_type_id',
                ])
            ->select($this->Users->Genres)
            ->select($this->Users->OrganizationTypes)
            ->contain([
                    'Genres',
                    'OrganizationTypes',
                    'Projects' => function ($q) use ($instance_id) {
                       return $q->where(['Projects.instance_id' => $instance_id]);
                    },
                ])
            ->first();

        // evitar mostrar datos de usuarios de otras instancias
        if (!$user) {
            $this->Flash->error(__('Invalid user'));
            return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
        }
        // var_dump($user);

        $owner_id = $user->id;
        $client  = $this->Auth->user();
        $client_id   = $client['id'];
        $client_role = $client['role_id'];
        $client_instance_id = $client['instance_id'];
        
        $this->set('is_authorized', false);
        if (
            $client_id == $owner_id ||
            $client_role == 2 ||
            (
                $client_instance_id == $instance->id &&
                $client_role == 1
            )
        ) {
            $this->set('is_authorized', true);
        }

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($instance_namespace = null)
    {
        # load instance data
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
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
            ->where(['Genres.name !=' => '[unused]'])
            ->order(['name' => 'ASC']);

        $organizationTypes = $this->Users->OrganizationTypes
            ->find('list', ['limit' => 200])
            ->where(['OrganizationTypes.name !=' => '[unused]'])
            ->where(['OrganizationTypes.instance_id' => $instance->id])
            ->order(['name' => 'ASC']);

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
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
    public function edit($instance_namespace = null, $id = null)
    {
        # load instance data
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $user = $this->Users->find()
            ->where([
                'instance_id' => $instance->id,
                'id' => $id
            ])
            ->first();

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
    
        $genres = $this->Users->Genres
            ->find('list', ['limit' => 200])
            ->where(['Genres.name !=' => '[unused]'])
            ->order(['name' => 'ASC']);

        $organizationTypes = $this->Users->OrganizationTypes
            ->find('list', ['limit' => 200])
            ->where(['OrganizationTypes.name !=' => '[unused]'])
            ->where(['OrganizationTypes.instance_id' => $instance->id])
            ->order(['name' => 'ASC']);

        $this->set(compact('user', 'genres', 'organizationTypes'));
        $this->set('_serialize', ['user']);

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($instance_namespace = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }
        $instance_id = $instance->id;

        $logged_user = $this->Auth->user();

        // delete user
        $user = $this->Users->get($id);
        if (isset($instance_id) && isset($user->instance_id)
            && $user->instance_id == $instance_id 
            && $this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        // redirect to view when deleting by admin, preview otherwise
        $this->Auth->logout();
        if($logged_user['id'] != $user->id) {
            $view_url = Router::url(['controller' => 'Instances', 'action' => 'view', $instance_namespace, '_full' => true]);
            $this->redirect($view_url);
        } else {
            $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
        }
    }
}
