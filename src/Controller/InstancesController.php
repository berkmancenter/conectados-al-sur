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
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $instances = $this->paginate($this->Instances);

        $this->set(compact('instances'));
        $this->set('_serialize', ['instances']);
    }

    /**
     * View method
     *
     * @param string|null $id Instance id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $instance = $this->Instances->get($id, [
            'contain' => ['Categories', 'OrganizationTypes', 'Projects', 'Users']
        ]);

        $this->set('instance', $instance);
        $this->set('_serialize', ['instance']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $instance = $this->Instances->newEntity();
        if ($this->request->is('post')) {
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
     * Edit method
     *
     * @param string|null $id Instance id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $instance = $this->Instances->get($id, [
            'contain' => []
        ]);
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
     *
     * @param string|null $id Instance id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $instance = $this->Instances->get($id);
        if ($this->Instances->delete($instance)) {
            $this->Flash->success(__('The instance has been deleted.'));
        } else {
            $this->Flash->error(__('The instance could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
