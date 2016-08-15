<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Subcontinents Controller
 *
 * @property \App\Model\Table\SubcontinentsTable $Subcontinents
 */
class SubcontinentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Continents']
        ];
        $subcontinents = $this->paginate($this->Subcontinents);

        $this->set(compact('subcontinents'));
        $this->set('_serialize', ['subcontinents']);
    }

    /**
     * View method
     *
     * @param string|null $id Subcontinent id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subcontinent = $this->Subcontinents->get($id, [
            'contain' => ['Continents', 'Countries']
        ]);

        $this->set('subcontinent', $subcontinent);
        $this->set('_serialize', ['subcontinent']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subcontinent = $this->Subcontinents->newEntity();
        if ($this->request->is('post')) {
            $subcontinent = $this->Subcontinents->patchEntity($subcontinent, $this->request->data);
            if ($this->Subcontinents->save($subcontinent)) {
                $this->Flash->success(__('The subcontinent has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The subcontinent could not be saved. Please, try again.'));
            }
        }
        $continents = $this->Subcontinents->Continents->find('list', ['limit' => 200]);
        $this->set(compact('subcontinent', 'continents'));
        $this->set('_serialize', ['subcontinent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Subcontinent id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subcontinent = $this->Subcontinents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subcontinent = $this->Subcontinents->patchEntity($subcontinent, $this->request->data);
            if ($this->Subcontinents->save($subcontinent)) {
                $this->Flash->success(__('The subcontinent has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The subcontinent could not be saved. Please, try again.'));
            }
        }
        $continents = $this->Subcontinents->Continents->find('list', ['limit' => 200]);
        $this->set(compact('subcontinent', 'continents'));
        $this->set('_serialize', ['subcontinent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Subcontinent id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subcontinent = $this->Subcontinents->get($id);
        if ($this->Subcontinents->delete($subcontinent)) {
            $this->Flash->success(__('The subcontinent has been deleted.'));
        } else {
            $this->Flash->error(__('The subcontinent could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
