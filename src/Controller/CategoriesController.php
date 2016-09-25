<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class CategoriesController extends AppController
{
    public function add($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);
        if (!$instance) { return $this->redirect(['controller' => 'Instances', 'action' => 'home']); }


        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            $category['instance_id'] = $instance->id;

            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
                foreach ($category->errors() as $error) {
                    $this->Flash->error(__(reset($error)));
                }
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            }
        }

        $this->set('category', $category);
        $this->set('instance', $instance);
    }

    public function edit($instance_namespace = null, $id = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);
        if (!$instance) { return $this->redirect(['controller' => 'Instances', 'action' => 'home']); }

        $category = $this->Categories->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
                foreach ($category->errors() as $error) {
                    $this->Flash->error(__(reset($error)));
                }
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            }
        }
        
        $this->set('category', $category);
        $this->set('instance', $instance);
    }

    public function delete($instance_namespace = null, $id = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }
        
        $this->request->allowMethod(['post', 'delete']);

        // get instance
        $instance = $this->App->getInstance($instance_namespace);
        if (!$instance) { return $this->redirect(['controller' => 'Instances', 'action' => 'home']); }
        $instance_id = $instance->id;

        $category = $this->Categories->get($id);
        if (isset($instance_id) && isset($category->instance_id)
            && $category->instance_id == $instance_id 
            && $this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
    }
}
