<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Continents Controller
 *
 * @property \App\Model\Table\ContinentsTable $Continents
 */
class ContinentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $continents = $this->paginate($this->Continents);

        $this->set(compact('continents'));
        $this->set('_serialize', ['continents']);
    }

    /**
     * View method
     *
     * @param string|null $id Continent id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $continent = $this->Continents->get($id, [
            'contain' => ['Subcontinents']
        ]);

        $this->set('continent', $continent);
        $this->set('_serialize', ['continent']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $continent = $this->Continents->newEntity();
        if ($this->request->is('post')) {
            $continent = $this->Continents->patchEntity($continent, $this->request->data);
            if ($this->Continents->save($continent)) {
                $this->Flash->success(__('The continent has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The continent could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('continent'));
        $this->set('_serialize', ['continent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Continent id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $continent = $this->Continents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $continent = $this->Continents->patchEntity($continent, $this->request->data);
            if ($this->Continents->save($continent)) {
                $this->Flash->success(__('The continent has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The continent could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('continent'));
        $this->set('_serialize', ['continent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Continent id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $continent = $this->Continents->get($id);
        if ($this->Continents->delete($continent)) {
            $this->Flash->success(__('The continent has been deleted.'));
        } else {
            $this->Flash->error(__('The continent could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
