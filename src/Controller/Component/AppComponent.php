<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class AppComponent extends Component
{
    public function initialize(array $config)
    {

    }

    public function beforeFilter(Event $event) {
        $this->controller = $event->subject();
    }

    // ADMIN
    public function getAdminNamespace() { return 'app'; }
    public function getAdminInstanceId() { return $this->getInstance($this->getAdminNamespace())->id; }

    public function getInstance($ns, $redirect = true) {

        $instance = TableRegistry::get('Instances')
            ->find()
            ->where(['Instances.namespace' => $ns])
            ->first();

        // prevent invalid instance call
        if ($redirect && !$instance) {
            $this->controller->redirect(['controller' => 'Instances', 'action' => 'home']);
        }
        return $instance;
    }

    public function getInstanceId($instance_namespace) {
        $instance = TableRegistry::get('Instances')
            ->find()            
            ->where(['namespace' => $instance_namespace])
            ->first();
        if ($instance) {
            return $instance->id;
        }
        return $instance;
    }
    public function getInstanceById($instance_id) {
        $instance = TableRegistry::get('Instances')
            ->find()            
            ->where(['id' => $instance_id])
            ->first();
        return $instance;
    }

    public function getOrganizationTypeById($instance_id, $organization_type_id) {
        $organization_type = TableRegistry::get('OrganizationTypes')
            ->find()
            ->where(['id' => $organization_type_id])
            ->where(['instance_id' => $instance_id])
            ->first();

        return $organization_type;
    }

    public function isAdminInstance($ns)
    {
        if ($ns == $this->getAdminNamespace())
        {
            return true;
        }
        return false;
    }

    public function getUserById($user_id) {

        $user = TableRegistry::get('Users')
            ->find()
            ->where(['Users.id' => $user_id])
            ->contain(['Genres', 'Projects', 'Instances'])
            ->first();

        return $user;
    }

    public function getUserInstanceData($user_id, $instance_id) {
        $data = TableRegistry::get('InstancesUsers')
            ->find()
            ->where(['user_id' => $user_id])
            ->where(['instance_id' => $instance_id])
            ->first();
        return $data;
    }
    public function isUserRegistered($user_id, $instance_id) {
        $data = TableRegistry::get('InstancesUsers')
            ->find()
            ->where(['user_id' => $user_id])
            ->where(['instance_id' => $instance_id])
            ->first();
        if ($data) {
            return true;
        }
        return false;
    }

    public function isAdmin($user_id, $instance_id)
    {
        $db_user = TableRegistry::get('Users')
            ->find()
            ->select(['id'])
            ->where(['Users.id' => $user_id])
            ->contain([
                'Instances' => function ($q) use ($instance_id) {
                   return $q
                        ->select(['id', 'namespace'])
                        ->where(['Instances.id' => 1])
                        ->orWhere(['Instances.id' => $instance_id]);
                },
            ])
            ->first();

        if ($db_user && count($db_user->instances) > 0) {

            foreach ($db_user->instances as $key => $instance) {

                $role_id = $instance->_joinData->role_id;

                // if sysadmin: return true
                if ($instance->id == 1 && $role_id == 1) {
                    return true;
                }
                // if admin: return true
                if ($instance->id == $instance_id && $role_id == 1) {
                    return true;
                }   
            }
        }
        return false;
    }

    public function isSysadmin($user_id) {

        $app_ns = $this->getAdminNamespace();

        $db_user = TableRegistry::get('Users')
            ->find()
            ->select(['id'])
            ->where(['Users.id' => $user_id])
            ->contain([
                'Instances' => function ($q) use ($app_ns) {
                   return $q
                        ->select(['id', 'namespace'])
                        ->where(['Instances.namespace' => $app_ns]);
                },
            ])
            ->first();

        if ($db_user &&                                         // found
             count($db_user->instances) > 0 &&                  // exist in admin instance
             $db_user->instances[0]->_joinData->role_id == 1) { // as admin guy
            return true;
        }
        return false;
    }

    public function setInstanceData($instance)
    {

    }
}

        // logged in users must be redirected to the related preview when 
        // trying to access to an unauthorized view
        // $user = $this->Auth->user();
        // if ($user) {

 
            // $instance_idxs = TableRegistry::get('InstancesUsers')
            //     ->find()
            //     ->where(['user_id' => $user['id']])
            //     ->contain([
            //         'Instances' => function ($q) {
            //            return $q->select(['Instances.id', 'Instances.namespace']);
            //         },
            //     ])
            //     ->all();
            // // var_dump($instance_idxs);

            // $count = $instance_idxs
            //             ->countBy(function ($item) { return "count"; })
            //             ->toArray()["count"];


            // // real ns
            // $instance_namespace = TableRegistry::get('Instances')
            //     ->find()
            //     ->select(['id', 'namespace'])
            //     ->where(['id' => $user['instance_id']])
            //     ->first()
            //     ->namespace;
            // // var_dump($instance_namespace);

        // }

// // when inside an instance, then the first parameter must be the $instance_namespace
            // if (isset($this->request->params['pass']) && isset($this->request->params['pass'][0]) ) {
                

            //     $instance_idxs = TableRegistry::get('InstancesUsers')
            //         ->find()
            //         ->where(['user_id' => $user['id']])
            //         ->contain([
            //             'Instances' => function ($q) {
            //                return $q
            //                     ->select(['Instances.id', 'Instances.namespace']);
            //             },
            //         ])
            //         ->all();
            //     // var_dump($instance_idxs);

            //     // url namespace
            //     $url_namespace = $this->request->params['pass'][0];

            //     $isValidInstance = $instance_idxs->some(
            //         function ($item) {
            //             var_dump($item);

            //             // same namespace
            //             // if ($url_namespace == $instance_namespace) {
            //             //     return true;
            //             // }

            //             return false;
            //         }
            //     );

            // }