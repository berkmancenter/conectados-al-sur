<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class CategoriesController extends AppController
{
    public function isAuthorized($user) {
        
        if (parent::isAuthorized($user)) { return true; }

        if ($this->request->action == 'add' || 
            $this->request->action == 'edit' || 
            $this->request->action == 'delete'
        ) {
            $instance_namespace = $this->request->params['pass'][0];

            $instance = $this->App->getInstance($instance_namespace, false); // do not redirect
            if ($instance && $this->App->isAdmin($user['id'], $instance->id)) {
                return true;
            }
        }
        return false;
    }

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
            $category->instance_id = $instance->id;

            $loc_field = $this->locHelper->fieldCategory();
            if ($this->Categories->save($category)) {
                $this->Flash->success($this->locHelper->crudAddSuccess($loc_field));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error($this->locHelper->crudAddError($loc_field));
                foreach ($category->errors() as $error) {
                    $this->Flash->error(__('{0}', reset($error)));
                }
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

            $loc_field = $this->locHelper->fieldCategory();
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success($this->locHelper->crudEditSuccess($loc_field));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error($this->locHelper->crudEditError($loc_field));
                foreach ($category->errors() as $error) {
                    $this->Flash->error(__('{0}', reset($error)));
                }

                // set variables for reedit
                if (isset($this->request->data['name']))    { $category->name    = $this->request->data['name'];    }
                if (isset($this->request->data['name_es'])) { $category->name_es = $this->request->data['name_es']; } 
            }
        }        
        $this->set('category', $category);
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

        $loc_field = $this->locHelper->fieldCategory();
        $category = $this->Categories->get($id);
        if (isset($instance_id) && isset($category->instance_id)
            && $category->instance_id == $instance_id 
            && $this->Categories->delete($category)) {
            $this->Flash->error($this->locHelper->crudDeleteSuccess($loc_field));
        } else {
            $this->Flash->error($this->locHelper->crudDeleteError($loc_field));
        }
        return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
    }
}
