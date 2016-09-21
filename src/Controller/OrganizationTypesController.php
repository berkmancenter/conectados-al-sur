<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * OrganizationTypes Controller
 *
 * @property \App\Model\Table\OrganizationTypesTable $OrganizationTypes
 */
class OrganizationTypesController extends AppController
{
    /**
     * Add method
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();


        $organizationType = $this->OrganizationTypes->newEntity();
        if ($this->request->is('post')) {
            $organizationType = $this->OrganizationTypes->patchEntity($organizationType, $this->request->data);
            $organizationType['instance_id'] = $instance->id;

            # NO ES ATÓMICO!
            $last_id = $this->OrganizationTypes
                ->find()
                ->select(['id'])
                ->order(['id' =>'DESC'])
                ->first()->id;
            // var_dump($last_id);
            $organizationType->id = $last_id + 1;

            if ($this->OrganizationTypes->save($organizationType)) {
                $this->Flash->success(__('The organization type has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The organization type could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            }
        }
        $this->set('organizationType', $organizationType);
        $this->set('instance', $instance);
        $this->set('instance_logo', $instance->logo);
        $this->set('instance_name', $instance->name);
        $this->set('instance_namespace', $instance_namespace);
        // $this->set(compact('organizationType'));
        // $this->set('_serialize', ['organizationType']);
    }

    /**
     * Edit method
     * @param string|null $id Organization Type id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($instance_namespace = null, $id = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();

        $organizationType = $this->OrganizationTypes->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $organizationType = $this->OrganizationTypes->patchEntity($organizationType, $this->request->data);
            if ($this->OrganizationTypes->save($organizationType)) {
                $this->Flash->success(__('The organization type has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            } else {
                $this->Flash->error(__('The organization type could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance_namespace]);
            }
        }

        $this->set('organizationType', $organizationType);
        $this->set('instance', $instance);
        $this->set('instance_logo', $instance->logo);
        $this->set('instance_name', $instance->name);
        $this->set('instance_namespace', $instance_namespace);
        // $this->set(compact('organizationType'));
        // $this->set('_serialize', ['organizationType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Organization Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($instance_namespace = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }
        
        $instance_id = TableRegistry::get('Instances')
            ->find()
            ->select(['id'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first()->id;

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
