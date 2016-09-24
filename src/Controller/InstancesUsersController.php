<?php
namespace App\Controller;

use App\Controller\AppController;


class InstancesUsersController extends AppController
{

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

    public function delete($id = null)
    {
        // todo: borrar proyectos asociados!
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
