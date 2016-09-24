<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InstancesUsers Controller
 *
 * @property \App\Model\Table\InstancesUsersTable $InstancesUsers
 */
class InstancesUsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Instances', 'Users', 'Roles', 'OrganizationTypes']
        ];
        $instancesUsers = $this->paginate($this->InstancesUsers);

        $this->set(compact('instancesUsers'));
        $this->set('_serialize', ['instancesUsers']);
    }

    /**
     * View method
     *
     * @param string|null $id Instances User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $instancesUser = $this->InstancesUsers->get($id, [
            'contain' => ['Instances', 'Users', 'Roles', 'OrganizationTypes']
        ]);

        $this->set('instancesUser', $instancesUser);
        $this->set('_serialize', ['instancesUser']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $instancesUser = $this->InstancesUsers->newEntity();
        if ($this->request->is('post')) {
            $instancesUser = $this->InstancesUsers->patchEntity($instancesUser, $this->request->data);
            if ($this->InstancesUsers->save($instancesUser)) {
                $this->Flash->success(__('The instances user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The instances user could not be saved. Please, try again.'));
            }
        }
        $instances = $this->InstancesUsers->Instances->find('list', ['limit' => 200]);
        $users = $this->InstancesUsers->Users->find('list', ['limit' => 200]);
        $roles = $this->InstancesUsers->Roles->find('list', ['limit' => 200]);
        $organizationTypes = $this->InstancesUsers->OrganizationTypes->find('list', ['limit' => 200]);
        $this->set(compact('instancesUser', 'instances', 'users', 'roles', 'organizationTypes'));
        $this->set('_serialize', ['instancesUser']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Instances User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $instancesUser = $this->InstancesUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $instancesUser = $this->InstancesUsers->patchEntity($instancesUser, $this->request->data);
            if ($this->InstancesUsers->save($instancesUser)) {
                $this->Flash->success(__('The instances user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The instances user could not be saved. Please, try again.'));
            }
        }
        $instances = $this->InstancesUsers->Instances->find('list', ['limit' => 200]);
        $users = $this->InstancesUsers->Users->find('list', ['limit' => 200]);
        $roles = $this->InstancesUsers->Roles->find('list', ['limit' => 200]);
        $organizationTypes = $this->InstancesUsers->OrganizationTypes->find('list', ['limit' => 200]);
        $this->set(compact('instancesUser', 'instances', 'users', 'roles', 'organizationTypes'));
        $this->set('_serialize', ['instancesUser']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Instances User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $instancesUser = $this->InstancesUsers->get($id);
        if ($this->InstancesUsers->delete($instancesUser)) {
            $this->Flash->success(__('The instances user has been deleted.'));
        } else {
            $this->Flash->error(__('The instances user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
