<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectStages Controller
 *
 * @property \App\Model\Table\ProjectStagesTable $ProjectStages
 */
class ProjectStagesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $projectStages = $this->paginate($this->ProjectStages);

        $this->set(compact('projectStages'));
        $this->set('_serialize', ['projectStages']);
    }

    /**
     * View method
     *
     * @param string|null $id Project Stage id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectStage = $this->ProjectStages->get($id, [
            'contain' => ['Projects']
        ]);

        $this->set('projectStage', $projectStage);
        $this->set('_serialize', ['projectStage']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectStage = $this->ProjectStages->newEntity();
        if ($this->request->is('post')) {
            $projectStage = $this->ProjectStages->patchEntity($projectStage, $this->request->data);
            if ($this->ProjectStages->save($projectStage)) {
                $this->Flash->success(__('The project stage has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project stage could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('projectStage'));
        $this->set('_serialize', ['projectStage']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Stage id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectStage = $this->ProjectStages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectStage = $this->ProjectStages->patchEntity($projectStage, $this->request->data);
            if ($this->ProjectStages->save($projectStage)) {
                $this->Flash->success(__('The project stage has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The project stage could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('projectStage'));
        $this->set('_serialize', ['projectStage']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project Stage id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectStage = $this->ProjectStages->get($id);
        if ($this->ProjectStages->delete($projectStage)) {
            $this->Flash->success(__('The project stage has been deleted.'));
        } else {
            $this->Flash->error(__('The project stage could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
