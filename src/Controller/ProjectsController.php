<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // public actions
        $this->Auth->allow(['index', 'view']);
    }

    public function isAuthorized($user = null)
    {
        if (parent::isAuthorized($user)) {
            return true;
        }
        
        // All registered users can add projects to their instance!
        if ($this->request->action === 'add') {

            // real ns
            $instance_namespace = TableRegistry::get('Instances')
                ->find()
                ->select(['id', 'namespace'])
                ->where(['id' => $user['instance_id']])
                ->first()
                ->namespace;

            // url namespace
            $url_namespace = $this->request->params['pass'][0];

            // same namespace
            if ($url_namespace == $instance_namespace) {
                return true;
            }
        }

        // The owner of a project can edit and delete it
        if (in_array($this->request->action, ['edit', 'delete'])) {
            $instance_namespace = (int)$this->request->params['pass'][0];
            $project_id = (int)$this->request->params['pass'][1];
            if ($this->Projects->isOwnedBy($project_id, $user['id'])) {
                return true;
            }
        }

        return false;
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == "sys") { $this->redirect($this->referer()); }

        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $user_conditions = array();
        $category_conditions = array();
        $conditions = array('Projects.instance_id' => $instance->id);

        // country_id
        $country_id = (int)$this->request->query("c");
        if ($country_id) { array_push($conditions, array('Projects.country_id' => $country_id)); }

        // organization_type_id
        $organization_type_id = (int)$this->request->query("o");
        if ($organization_type_id) { array_push($conditions, array('Projects.organization_type_id' => $organization_type_id)); }

        // project_stage_id
        $project_stage_id = (int)$this->request->query("s");
        if ($project_stage_id) { array_push($conditions, array('Projects.project_stage_id' => $project_stage_id)); }

        // genre_id
        $genre_id = (int)$this->request->query("g");
        if ($genre_id) { $user_conditions = array('genre_id' => $genre_id); }

        // category_id
        $category_id = (int)$this->request->query("t");
        if ($category_id) { $category_conditions = array('Categories.id' => $category_id); }
        

        $this->paginate = [
            'limit'      => 5,
            'contain'    => [
                'Users' => function ($q) use ($user_conditions) {
                   return $q
                        ->select(['id','genre_id'])
                        ->where($user_conditions);
                }
            ],
            'conditions' => $conditions
        ];
        $projects = $this->paginate(
            $this->Projects
                ->find()
                ->matching('Categories', function(\Cake\ORM\Query $q) use ($category_conditions) {
                    return $q->where($category_conditions);
                })
                ->distinct(['Projects.id'])
        );

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set('instance_name', $instance->name);
        $this->set(compact('projects'));
        $this->set('_serialize', ['projects']);
    }

    /**
     * View method
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($instance_namespace = null, $id = null)
    {
        // block sys instance
        if ($instance_namespace == "sys") { $this->redirect($this->referer()); }

        # load instance data
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

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
        $this->set('instance_name', $instance->name);
        $this->set('_serialize', ['project']);
    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == "sys") { $this->redirect($this->referer()); }

        # load instance data
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

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
            ->where(['OrganizationTypes.instance_id' => $instance->id])
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
            ->where(['Categories.instance_id' => $instance->id])
            ->order(['name' => 'ASC'])
            ->all();


        // $users = $this->Projects->Users->find('list', ['limit' => 200]);
        // $cities = $this->Projects->Cities->find('list', ['limit' => 200]);

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set('instance_name', $instance->name);
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
        // block sys instance
        if ($instance_namespace == "sys") { $this->redirect($this->referer()); }

        # load instance data
        $instance = TableRegistry::get('Instances')
            ->find()
            ->select(['id', 'name', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

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
            ->where(['OrganizationTypes.instance_id' => $instance->id])
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
            ->where(['Categories.instance_id' => $instance->id])
            ->order(['name' => 'ASC'])
            ->all();

        // $users = $this->Projects->Users->find('list', ['limit' => 200]);
        // $cities = $this->Projects->Cities->find('list', ['limit' => 200]);

        $this->set('instance_namespace', $instance_namespace);
        $this->set('instance_logo', $instance->logo);
        $this->set('instance_name', $instance->name);
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

        // block sys instance
        if ($instance_namespace == "sys") { $this->redirect($this->referer()); }

        $project = $this->Projects->get($id);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
    }
}
