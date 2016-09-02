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
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();

        $country_id = (int)$this->request->query["c"];
        $this->paginate = [
            'limit'      => 5,
            'contain'    => ['Users', 'OrganizationTypes', 'ProjectStages', 'Countries', 'Cities'],
            'conditions' => [
                'Projects.instance_id' => $instance->id,
                'Projects.country_id' => $country_id
            ]
        ];
        $projects = $this->paginate($this->Projects);

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set(compact('projects'));
        $this->set('_serialize', ['projects']);
    }

    /**
     * View method
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($instance_namespace = null, $id = null)
    {
        # load instance data
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();

        $project = $this->Projects->get($id, [
            'contain' => [
                'Users' => function ($q) {
                    return $q->select(['id', 'name']);
                },
                'OrganizationTypes',
                'ProjectStages',
                'Countries',
                'Categories'
            ]
        ]);
        // var_dump($project);

        $this->set('project', $project);
        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set('_serialize', ['project']);
    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($instance_namespace = null)
    {
        # load instance data
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();

        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {

            # NO ES ATÓMICO!
            $last_id = $this->Projects
                ->find()
                ->select(['id'])
                ->order(['id' =>'DESC'])
                ->first()->id;
            #var_dump($last_id);

            $project = $this->Projects->patchEntity($project, $this->request->data);
            $project->id = $last_id + 1;
            $project->instance_id = $instance->id;

            // OJO!: MIENTRAS
            $project->user_id = 0;
            // 

            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
            }
        }

        // OrganizationTypes
        $organizationTypes = $this->Projects->OrganizationTypes
            ->find('list')
            ->where(['OrganizationTypes.name !=' => '[unused]'])
            ->order(['name' => 'ASC'])
            ->all();

        // countries
        $countries = $this->Projects->Countries
            ->find('list')
            ->where(['Countries.id !=' => '0'])
            ->order(['name' => 'ASC'])
            ->all();

        // ProjectStages
        $projectStages = $this->Projects->ProjectStages
            ->find('list')
            ->where(['ProjectStages.name !=' => '[unused]'])
            ->order(['id' => 'ASC'])
            ->all();

        // Categories
        $categories = $this->Projects->Categories
            ->find('list', ['limit' => 200])
            ->where(['Categories.name !=' => '[unused]'])
            ->order(['name' => 'ASC'])
            ->all();


        // $users = $this->Projects->Users->find('list', ['limit' => 200]);
        // $cities = $this->Projects->Cities->find('list', ['limit' => 200]);

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set(compact('project', 'organizationTypes', 'projectStages', 'countries', 'categories','instance_namespace'));
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
        # load instance data
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();

        $project = $this->Projects->get($id, [
            'contain' => ['Categories']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['controller' => 'Projects', 'action' => 'view', $instance_namespace, $id]);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Projects', 'action' => 'view', $instance_namespace, $id]);
            }
        }

        // OrganizationTypes
        $organizationTypes = $this->Projects->OrganizationTypes
            ->find('list')
            ->where(['OrganizationTypes.name !=' => '[unused]'])
            ->order(['name' => 'ASC'])
            ->all();

        // countries
        $countries = $this->Projects->Countries
            ->find('list')
            ->where(['Countries.id !=' => '0'])
            ->order(['name' => 'ASC'])
            ->all();

        // ProjectStages
        $projectStages = $this->Projects->ProjectStages
            ->find('list')
            ->where(['ProjectStages.name !=' => '[unused]'])
            ->order(['id' => 'ASC'])
            ->all();

        // Categories
        $categories = $this->Projects->Categories
            ->find('list', ['limit' => 200])
            ->where(['Categories.name !=' => '[unused]'])
            ->order(['name' => 'ASC'])
            ->all();

        // $users = $this->Projects->Users->find('list', ['limit' => 200]);
        // $cities = $this->Projects->Cities->find('list', ['limit' => 200]);

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set(compact('project', 'organizationTypes', 'projectStages', 'countries', 'categories', 'instance_namespace'));
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
