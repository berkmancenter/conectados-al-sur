<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\View\Helper\UrlHelper;

class AppHelper extends Helper
{
    public $helpers = ['Url', 'Form', 'Html'];
    
    public function isSysadmin($user_id)
    {
        return $this->isAdmin($user_id, 1);
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

        if ($db_user &&                                         // found
             count($db_user->instances) > 0 &&                  // exist in this instance
             $db_user->instances[0]->_joinData->role_id == 1) { // as admin guy
            return true;
        }
        return false;
    }

    public function getAdminNamespace() { return 'admin'; }
    public function getAdminInstanceId() { return $this->getInstance($this->getAdminNamespace())->id; }
    public function getInstance($ns) {

        $instance = TableRegistry::get('Instances')
            ->find()
            ->where(['Instances.namespace' => $ns])
            ->first();
        return $instance;
    }
    public function isAdminInstance($instance_id) {
        return $instance_id == $this->getAdminInstanceId();
    }

    public function displayInstanceIndexShortcut() {
        return "<a href=" . $this->Url->build(['controller' => 'Instances', 'action' => 'index']) . "><i class='fi-arrow-left size-36'></i></a>";
    }
    public function displayInstancePreviewShortcut($instance_namespace) {
        return "<a href=" . $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]) . "><i class='fi-home size-36'></i></a>";
    }
    public function displayInstanceMapShortcut($instance_namespace) {
        return "<a href=" . $this->Url->build(['controller' => 'Instances', 'action' => 'map', $instance_namespace]) . "><i class='fi-map size-36'></i></a>";
    }
    public function displayInstanceDotsShortcut($instance_namespace) {
        return "<a href=" . $this->Url->build(['controller' => 'Instances', 'action' => 'dots', $instance_namespace]) . "><i class='fi-graph-pie size-36'></i></a>";
    }
    public function displayInstanceViewShortcut($instance_namespace) {
        return "<a href=" . $this->Url->build(['controller' => 'Instances', 'action' => 'view', $instance_namespace]) . "><i class='fi-magnifying-glass size-36'></i>View</a>";
    }
    public function displayInstanceEditShortcut($instance_namespace) {
        return "<a href=" . $this->Url->build(['controller' => 'Instances', 'action' => 'edit', $instance_namespace]) . "><i class='fi-page-edit size-36'></i>Edit</a>";
    }
    public function displayInstanceDeleteShortcut($instance_namespace, $instance_name) {
        return $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['action' => 'delete', $instance_namespace], [
                'escape' => false, 
                'confirm' => __('Are you sure you want to delete the "{0}" instance?. This operation cannot be undone. All related data will be erased!', $instance_name)
            ]);
    }
}