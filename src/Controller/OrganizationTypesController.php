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

        $organization_type = $this->OrganizationTypes->newEntity();
        if ($this->request->is('post')) {

            $organization_type = $this->OrganizationTypes->patchEntity($organization_type, $this->request->data);
            $organization_type->instance_id = $instance->id;

            if ($this->OrganizationTypes->save($organization_type)) {
                $this->Flash->success(__('The organization type has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The organization type could not be saved. Please, try again.'));
                foreach ($organization_type->errors() as $error) {
                    $this->Flash->error(__(reset($error)));
                }
            }
        }
        $this->set('organization_type', $organization_type);
        $this->set('instance', $instance);
    }

    public function edit($instance_namespace = null, $id = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);
        if (!$instance) { return $this->redirect(['controller' => 'Instances', 'action' => 'home']); }

        $organization_type = $this->OrganizationTypes->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $organization_type = $this->OrganizationTypes->patchEntity($organization_type, $this->request->data);
            if ($this->OrganizationTypes->save($organization_type)) {
                $this->Flash->success(__('The organization type has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The organization type could not be saved. Please, try again.'));
                foreach ($organization_type->errors() as $error) {
                    $this->Flash->error(__(reset($error)));
                }
                
                // set variables for reedit
                if (isset($this->request->data['name']))    { $organization_type->name    = $this->request->data['name'];    }
                if (isset($this->request->data['name_es'])) { $organization_type->name_es = $this->request->data['name_es']; }
            }
        }
        $this->set('organization_type', $organization_type);
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

        $organization_type = $this->OrganizationTypes->get($id);
        if (isset($instance_id) && isset($organization_type->instance_id)
            && $organization_type->instance_id == $instance_id 
            && $this->OrganizationTypes->delete($organization_type)) {
            $this->Flash->success(__('The organization type has been deleted.'));
        } else {
            $this->Flash->error(__('The organization type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
    }
}
