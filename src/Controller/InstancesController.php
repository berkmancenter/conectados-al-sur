<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Instances Controller
 *
 * @property \App\Model\Table\InstancesTable $Instances
 */
class InstancesController extends AppController
{

    /**
     * Index method
     */
    public function index()
    {
        $instances = $this->paginate($this->Instances);

        $this->set(compact('instances'));
        $this->set('_serialize', ['instances']);
    }


    /**
     * PREView method
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function preview($instance_namespace = null)
    {
        # load instance data
        $instance = $this->Instances
            ->find()
            ->where(['Instances.namespace' => $instance_namespace])
            ->contain(['Categories', 'OrganizationTypes', 'Projects', 'Users'])
            ->first();

        $this->set('instance', $instance);
        $this->set('_serialize', ['instance']);
    }

    /**
     * View method
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($instance_namespace = null)
    {
        $instance = $this->Instances
            ->find()
            ->where(['Instances.namespace' => $instance_namespace])
            ->contain(['Categories', 'OrganizationTypes', 'Projects', 'Users'])
            ->first();

        $this->set('instance', $instance);
        $this->set('_serialize', ['instance']);
    }

    /**
     * Add method
     * Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $instance = $this->Instances->newEntity();
        if ($this->request->is('post')) {

            # NO ES ATÓMICO!
            $last_id = $this->Instances
                ->find()
                ->select(['id'])
                ->order(['id' =>'DESC'])
                ->first()->id;
            #var_dump($last_id);

            $instance = $this->Instances->patchEntity($instance, $this->request->data);
            $instance->id = $last_id + 1;
            if ($this->Instances->save($instance)) {
                $this->Flash->success(__('The instance has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The instance could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('instance'));
        $this->set('_serialize', ['instance']);
    }

    /**
     * Edit method
     * Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($instance_namespace = null)
    {
        $instance = $this->Instances
            ->find()
            ->where(['Instances.namespace' => $instance_namespace])
            ->contain([])
            ->first();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $instance = $this->Instances->patchEntity($instance, $this->request->data);
            if ($this->Instances->save($instance)) {
                $this->Flash->success(__('The instance has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The instance could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('instance'));
        $this->set('_serialize', ['instance']);
    }

    /**
     * Delete method
     * Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($instance_namespace = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $instance = $this->Instances
            ->find()
            ->where(['Instances.namespace' => $instance_namespace])
            ->contain([])
            ->first();
        
        if ($this->Instances->delete($instance)) {
             $this->Flash->success(__('The instance "{0}" has been deleted.', $instance->name));
        } else {
            $this->Flash->error(__('The instance could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
