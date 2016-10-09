<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class InstancesUsersController extends AppController
{
    public function isAuthorized($user = null)
    {
        if (parent::isAuthorized($user)) { return true; }
        
        // can add, edit and delete to himself
        if ($this->request->action == 'add' || $this->request->action == 'edit' || $this->request->action == 'delete') {
            $requested_id = $this->request->params['pass'][0];
            if ($requested_id == $user['id']) {
                return true;
            }
        }
        return false;
    }

    public function add($user_id = null)
    {
        // get user
        $user = TableRegistry::get('Users')->find()
            ->where(['id' => $user_id])
            ->first();
        if (!$user) {
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }
        $user_admin_instance = $this->App->getUserInstanceData($user_id, $this->App->getAdminInstanceId());

        $instances_user = $this->InstancesUsers->newEntity();
        if ($this->request->is('post')) {

            // check values
            if (!array_key_exists("instance_namespace", $this->request->data) ||
                !array_key_exists("passphrase", $this->request->data) ) {
                return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
            }
            $pass = $this->request->data["passphrase"];

            // get namespace
            $instance = $this->App->getInstance($this->request->data["instance_namespace"], false);
            if ($instance) {                    
                if ($instance->passphrase == $pass) {

                    $last_ui = $this->App->getUserInstanceData($user_id, $instance->id);
                    if (!$last_ui) {

                        $null_org_id = TableRegistry::get('OrganizationTypes')
                            ->find()
                            ->select(['id', 'name', 'instance_id'])
                            ->where(['name' => '[null]'])
                            ->where(['instance_id' => $instance->id])
                            ->first()->id;
                        // var_dump($null_org_id);

                        // patch user->instance
                        $ui_data = array();
                        $ui_data = array_merge($ui_data, array('role_id'              => 0));
                        $ui_data = array_merge($ui_data, array('contact'              => $user_admin_instance->contact));
                        $ui_data = array_merge($ui_data, array('main_organization'    => '[null]'));
                        $ui_data = array_merge($ui_data, array('organization_type_id' => $null_org_id));

                        $instances_user = $this->InstancesUsers->patchEntity($instances_user, $ui_data);
                        $instances_user->user_id = $user_id;
                        $instances_user->instance_id = $instance->id;
                        if ($this->InstancesUsers->save($instances_user)) {
                            $this->Flash->success(__('The user data has been saved. Please, complete your app data.'));
                            return $this->redirect([
                                    'controller' => 'InstancesUsers',
                                    'action' => 'edit',
                                    $instances_user->user_id,
                                    $instance->namespace
                            ]);
                        } else {
                            foreach ($instances_user->errors() as $error) {
                                $this->Flash->error(__('{0}', reset($error)));
                            }
                        }
                    } else {
                        $this->Flash->error(__('Sorry, your are already registered on this app.'));
                    }
                } else {
                    $this->Flash->error(__('Sorry, your profile sign up data is invalid.'));
                }
            } else {
                $this->Flash->error(__('Sorry, your profile sign up data is invalid.'));
            }
             
        }
        $this->set('user_id', $user_id);
        $this->set(compact('instances_user'));
        $this->set('_serialize', ['instances_user']);
    }

    public function edit($user_id = null, $instance_namespace = null)
    {
        // retrieve instance
        $instance = $this->App->getInstance($instance_namespace);

        // get user
        $user = TableRegistry::get('Users')->find()
            ->where(['id' => $user_id])
            ->first();
        if (!$user) { 
            return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
        }

        // retrieve association
        $instances_user = $this->App->getUserInstanceData($user_id, $instance->id);
        if (!$instances_user) {
            return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            // role management
            if (array_key_exists('grant', $this->request->data)) {
                $grant = $this->request->data["grant"];

                // check authority
                $client = $this->Auth->user();
                if (!$client || !$this->App->isAdmin($client['id'], $instance->id)) {
                    $this->Flash->error(__('You are not authorized to perform this action.'));
                    return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
                }

                $message = '';
                $is_admin_instance = $instances_user->instance_id == $this->App->getAdminInstanceId();

                if ($grant) {
                    
                    // give privileges
                    $instances_user->role_id = 1;
                    if ($is_admin_instance) { $message = 'SysAdmin privileges were granted'; }
                    else {                    $message = 'Admin privileges were granted'; }

                } else {
                    
                    // prevent leaving no users of a single type
                    $remaining = $this->InstancesUsers->find()
                        ->where([
                            'instance_id' => $instance->id,
                            'role_id' => 1
                        ])
                        ->count();

                    if ($remaining == 1) {
                        if ($is_admin_instance) {
                            $this->Flash->error(__('Could not revoke user privileges. At least there must exist one sysadmin.'));
                        } else {
                            $this->Flash->error(__('Could not revoke user privileges. At least there must exist one admin for this instance.'));
                        }
                        return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
                    }

                    // remove privileges
                    $instances_user->role_id = 0;
                    if ($is_admin_instance) { $message = 'SysAdmin privileges were revoked'; }
                    else {                    $message = 'Admin privileges were revoked';    }
                    
                }

                $message = $message . ' for user ' . $user->email . '.';
                if ($this->InstancesUsers->save($instances_user)) {
                    $this->Flash->success(__('{0}', $message));
                } else {
                    $this->Flash->error(__('Could not modify user privileges.'));
                }
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            }


            $instances_user = $this->InstancesUsers->patchEntity($instances_user, $this->request->data);
            if ($this->InstancesUsers->save($instances_user)) {
                $this->Flash->success(__('Your profile data was saved for: ' . $instance->name));
                return $this->redirect(['controller' => 'Users', 'action' => 'view', $user_id]);
            } else {
                $this->Flash->error(__('There was an error while trying to save your profile data. Please, try again.'));
                foreach ($instances_user->errors() as $error) {
                    $this->Flash->error(__('{0}', reset($error)));
                }

                // set variables for reedit
                if (isset($this->request->data['contact']))           { $instances_user->contact = $this->request->data['contact']; }
                if (isset($this->request->data['main_organization'])) { $instances_user->main_organization = $this->request->data['main_organization']; }
            }
        }

        $organization_types = TableRegistry::get('OrganizationTypes')
            ->find('list')
            ->where(['OrganizationTypes.name !=' => '[null]'])
            ->where(['OrganizationTypes.instance_id' => $instance->id])
            ->order(['name' =>'ASC'])
            ->all();

        $this->set(compact('instances_user', 'organization_types'));
        $this->set('_serialize', ['instances_user']);
        $this->set('user_id', $user_id);
        $this->set('instance', $instance);
    }

    public function delete($user_id = null, $instance_id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        // retrieve instance
        $instance = $this->App->getInstanceById($instance_id);
        if (!$instance) {
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        // retrieve association
        $instances_user = $this->App->getUserInstanceData($user_id, $instance_id);
        if (!$instances_user) {
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }
        
        // delete instance user
        if ($this->InstancesUsers->delete($instances_user)) {

            // delete projects
            $projects = TableRegistry::get('Projects')
                ->find()
                ->where(['user_id' => $user_id])
                ->where(['instance_id' => $instance_id])
                ->all();
            foreach ($projects as $project) {
                TableRegistry::get('Projects')->delete($project);
            }

            $this->Flash->success(__('Profile and related projects were deleted: ' . $instance->name));
        } else {
            $this->Flash->error(__('Failed to delete this profile. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Users', 'action' => 'view', $user_id]);
    }
}
