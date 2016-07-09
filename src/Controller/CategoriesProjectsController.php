<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CategoriesProjects Controller
 *
 * @property \App\Model\Table\CategoriesProjectsTable $CategoriesProjects
 */
class CategoriesProjectsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projects', 'Categories']
        ];
        $categoriesProjects = $this->paginate($this->CategoriesProjects);

        $this->set(compact('categoriesProjects'));
        $this->set('_serialize', ['categoriesProjects']);
    }

    /**
     * View method
     *
     * @param string|null $id Categories Project id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $categoriesProject = $this->CategoriesProjects->get($id, [
            'contain' => ['Projects', 'Categories']
        ]);

        $this->set('categoriesProject', $categoriesProject);
        $this->set('_serialize', ['categoriesProject']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoriesProject = $this->CategoriesProjects->newEntity();
        if ($this->request->is('post')) {
            $categoriesProject = $this->CategoriesProjects->patchEntity($categoriesProject, $this->request->data);
            if ($this->CategoriesProjects->save($categoriesProject)) {
                $this->Flash->success(__('The categories project has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The categories project could not be saved. Please, try again.'));
            }
        }
        $projects = $this->CategoriesProjects->Projects->find('list', ['limit' => 200]);
        $categories = $this->CategoriesProjects->Categories->find('list', ['limit' => 200]);
        $this->set(compact('categoriesProject', 'projects', 'categories'));
        $this->set('_serialize', ['categoriesProject']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Categories Project id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoriesProject = $this->CategoriesProjects->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoriesProject = $this->CategoriesProjects->patchEntity($categoriesProject, $this->request->data);
            if ($this->CategoriesProjects->save($categoriesProject)) {
                $this->Flash->success(__('The categories project has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The categories project could not be saved. Please, try again.'));
            }
        }
        $projects = $this->CategoriesProjects->Projects->find('list', ['limit' => 200]);
        $categories = $this->CategoriesProjects->Categories->find('list', ['limit' => 200]);
        $this->set(compact('categoriesProject', 'projects', 'categories'));
        $this->set('_serialize', ['categoriesProject']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Categories Project id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoriesProject = $this->CategoriesProjects->get($id);
        if ($this->CategoriesProjects->delete($categoriesProject)) {
            $this->Flash->success(__('The categories project has been deleted.'));
        } else {
            $this->Flash->error(__('The categories project could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
