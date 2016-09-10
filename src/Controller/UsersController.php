<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($instance_namespace = null, $id = null)
    {
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();

        $user = $this->Users->find()
            ->where(['Users.id' => $id])
            ->select([
                    'id',
                    'name',
                    'contact',
                    'genre_id',
                    'main_organization',
                    'organization_type_id',
                ])
            ->select($this->Users->Genres)
            ->select($this->Users->OrganizationTypes)
            ->contain([
                    'Genres',
                    'OrganizationTypes',
                    'Projects'
                ])
            ->first();

        // var_dump($user);


        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $genres = $this->Users->Genres->find('list', ['limit' => 200]);
        $organizationTypes = $this->Users->OrganizationTypes->find('list', ['limit' => 200]);
        $this->set(compact('user', 'genres', 'organizationTypes'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $genres = $this->Users->Genres->find('list', ['limit' => 200]);
        $organizationTypes = $this->Users->OrganizationTypes->find('list', ['limit' => 200]);
        $this->set(compact('user', 'genres', 'organizationTypes'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
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

        $user = $this->Users->get($id);
        if (isset($instance_id) && isset($user->instance_id)
            && $user->instance_id == $instance_id 
            && $this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        // redirect to view when deleting by admin, preview otherwise
        $view_url = Router::url(['controller' => 'Instances', 'action' => 'view', $instance_namespace, '_full' => true]);
        if($this->referer() == $view_url) {
            $this->redirect($view_url);
        } else {
            $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
        }
    }
}
