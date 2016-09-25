<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class OrganizationTypesController extends AppController
{

    public function add($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);
        if (!$instance) { return $this->redirect(['controller' => 'Instances', 'action' => 'home']); }

        $organizationType = $this->OrganizationTypes->newEntity();
        if ($this->request->is('post')) {
            $organizationType = $this->OrganizationTypes->patchEntity($organizationType, $this->request->data);
            $organizationType['instance_id'] = $instance->id;

            if ($this->OrganizationTypes->save($organizationType)) {
                $this->Flash->success(__('The organization type has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The organization type could not be saved. Please, try again.'));
                foreach ($organizationType->errors() as $error) {
                    $this->Flash->error(__(reset($error)));
                }
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            }
        }
        $this->set('organizationType', $organizationType);
        $this->set('instance', $instance);
    }

    public function edit($instance_namespace = null, $id = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);
        if (!$instance) { return $this->redirect(['controller' => 'Instances', 'action' => 'home']); }

        $organizationType = $this->OrganizationTypes->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $organizationType = $this->OrganizationTypes->patchEntity($organizationType, $this->request->data);
            if ($this->OrganizationTypes->save($organizationType)) {
                $this->Flash->success(__('The organization type has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The organization type could not be saved. Please, try again.'));
                foreach ($organizationType->errors() as $error) {
                    $this->Flash->error(__(reset($error)));
                }
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            }
        }
        $this->set('organizationType', $organizationType);
        $this->set('instance', $instance);
    }

    public function delete($instance_namespace = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }
        
        // get instance
        $instance = $this->App->getInstance($instance_namespace);
        if (!$instance) { return $this->redirect(['controller' => 'Instances', 'action' => 'home']); }
        $instance_id = $instance->id;

        $organizationType = $this->OrganizationTypes->get($id);
        if (isset($instance_id) && isset($organizationType->instance_id)
            && $organizationType->instance_id == $instance_id 
            && $this->OrganizationTypes->delete($organizationType)) {
            $this->Flash->success(__('The organization type has been deleted.'));
        } else {
            $this->Flash->error(__('The organization type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
    }
}
