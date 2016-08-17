<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($instance_namespace = null)
    {
        $instance_id = TableRegistry::get('Instances')
            ->find()
            ->select(['id'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first()->id;

        $this->paginate = [
            'contain'    => ['Users', 'OrganizationTypes', 'ProjectStages', 'Countries', 'Cities'],
            'conditions' => ['Projects.instance_id' => $instance_id]
        ];
        $projects = $this->paginate($this->Projects);

        $this->set(compact('projects'));
        $this->set('_serialize', ['projects']);
    }

    /**
     * Graph method
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function graph($instance_namespace = null)
    {
        $instance_id = TableRegistry::get('Instances')
            ->find()
            ->select(['id'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first()->id;

        $projects = $this->Projects
            ->find()
            ->contain(['Users', 'OrganizationTypes', 'ProjectStages', 'Countries', 'Categories'])
            ->where(['Projects.instance_id' => $instance_id])
            ->all();

        $this->set(compact('projects', 'instance_namespace'));
        $this->set('_serialize', ['projects']);
    }

    /**
     * Map method
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function map($instance_namespace = null)
    {
        $instance_id = TableRegistry::get('Instances')
            ->find()
            ->select(['id'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first()->id;

        $projects = $this->Projects
            ->find()
            ->contain(['Users', 'OrganizationTypes', 'ProjectStages', 'Countries', 'Categories'])
            ->where(['Projects.instance_id' => $instance_id])
            ->all();

        $this->set(compact('projects', 'instance_namespace'));
        $this->set('_serialize', ['projects']);
    }

    /**
     * View method
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($instance_namespace = null, $id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Users', 'OrganizationTypes', 'ProjectStages', 'Countries', 'Cities', 'Categories']
        ]);

        $this->set('project', $project);
        $this->set('instance_namespace', $instance_namespace);
        $this->set('_serialize', ['project']);
    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($instance_namespace = null)
    {
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $users = $this->Projects->Users->find('list', ['limit' => 200]);
        $organizationTypes = $this->Projects->OrganizationTypes->find('list', ['limit' => 200]);
        $projectStages = $this->Projects->ProjectStages->find('list', ['limit' => 200]);
        $countries = $this->Projects->Countries->find('list', ['limit' => 200]);
        $cities = $this->Projects->Cities->find('list', ['limit' => 200]);
        $categories = $this->Projects->Categories->find('list', ['limit' => 200]);
        $this->set(compact('project', 'users', 'organizationTypes', 'projectStages', 'countries', 'cities', 'categories','instance_namespace'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($instance_namespace = null, $id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Categories']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $users = $this->Projects->Users->find('list', ['limit' => 200]);
        $organizationTypes = $this->Projects->OrganizationTypes->find('list', ['limit' => 200]);
        $projectStages = $this->Projects->ProjectStages->find('list', ['limit' => 200]);
        $countries = $this->Projects->Countries->find('list', ['limit' => 200]);
        $cities = $this->Projects->Cities->find('list', ['limit' => 200]);
        $categories = $this->Projects->Categories->find('list', ['limit' => 200]);
        $this->set(compact('project', 'users', 'organizationTypes', 'projectStages', 'countries', 'cities', 'categories', 'instance_namespace'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($instance_namespace = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
    }
}
