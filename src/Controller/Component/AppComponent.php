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

    public function getInstance($ns) {

        $instance = TableRegistry::get('Instances')
            ->find()
            ->where(['Instances.namespace' => $ns])
            ->first();

        // prevent invalid instance call
        if (!$instance) {
            $this->controller->redirect(['controller' => 'Instances', 'action' => 'home']);
        }
        return $instance;
    }

    public function isAdminInstance($ns)
    {
        if ($ns == "admin")
        {
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