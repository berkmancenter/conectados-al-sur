<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrganizationTypes Controller
 *
 * @property \App\Model\Table\OrganizationTypesTable $OrganizationTypes
 */
class OrganizationTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $organizationTypes = $this->paginate($this->OrganizationTypes);

        $this->set(compact('organizationTypes'));
        $this->set('_serialize', ['organizationTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Organization Type id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $organizationType = $this->OrganizationTypes->get($id, [
            'contain' => ['Projects', 'Users']
        ]);

        $this->set('organizationType', $organizationType);
        $this->set('_serialize', ['organizationType']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $organizationType = $this->OrganizationTypes->newEntity();
        if ($this->request->is('post')) {
            $organizationType = $this->OrganizationTypes->patchEntity($organizationType, $this->request->data);
            if ($this->OrganizationTypes->save($organizationType)) {
                $this->Flash->success(__('The organization type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The organization type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('organizationType'));
        $this->set('_serialize', ['organizationType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Organization Type id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $organizationType = $this->OrganizationTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $organizationType = $this->OrganizationTypes->patchEntity($organizationType, $this->request->data);
            if ($this->OrganizationTypes->save($organizationType)) {
                $this->Flash->success(__('The organization type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The organization type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('organizationType'));
        $this->set('_serialize', ['organizationType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Organization Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $organizationType = $this->OrganizationTypes->get($id);
        if ($this->OrganizationTypes->delete($organizationType)) {
            $this->Flash->success(__('The organization type has been deleted.'));
        } else {
            $this->Flash->error(__('The organization type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
