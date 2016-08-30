<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
    /**
     * Add method
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($instance_namespace = null)
    {
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();


        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            $category['instance_id'] = $instance->id;

            # NO ES ATÓMICO!
            $last_id = $this->Categories
                ->find()
                ->select(['id'])
                ->order(['id' =>'DESC'])
                ->first()->id;
            // var_dump($last_id);
            $category->id = $last_id + 1;

            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            }
        }
        $this->set('category', $category);
        $this->set('instance', $instance);
        $this->set('instance_logo', $instance->logo);
        $this->set('instance_namespace', $instance_namespace);
        // $this->set(compact('category', 'projects'));
        // $this->set('_serialize', ['category']);
    }

    /**
     * Edit method
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($instance_namespace = null, $id = null)
    {
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();

        $category = $this->Categories->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            }
        }
        
        $this->set('category', $category);
        $this->set('instance', $instance);
        $this->set('instance_logo', $instance->logo);
        $this->set('instance_namespace', $instance_namespace);
        // $this->set(compact('category'));
        // $this->set('_serialize', ['category']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($instance_namespace = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $instance_id = TableRegistry::get('Instances')
            ->find()
            ->select(['id'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first()->id;

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
