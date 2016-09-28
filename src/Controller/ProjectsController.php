<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
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
        $this->Auth->allow(['index', 'view', 'exportCsv']);
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
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);

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

        // var_dump($_SERVER['QUERY_STRING']);
        $this->set('filter_query', $_SERVER['QUERY_STRING']);
        $this->set('instance', $instance);
        $this->set(compact('projects'));
        $this->set('_serialize', ['projects']);
    }

    public function exportCsv($instance_namespace)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);
        $instance_id = $instance->id;


        // BUILD FILTER CONDITIONS
        // -----------------------------------------------------------------------------
        $user_conditions = array();
        $category_conditions = array();
        $conditions = array('Projects.instance_id' => $instance->id);

        // project_id
        $project_id = (int)$this->request->query("p");
        if ($project_id) { array_push($conditions, array('Projects.id' => $project_id)); }

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
        if ($genre_id) { $user_conditions = array('Users.genre_id' => $genre_id); }

        // category_id
        $category_id = (int)$this->request->query("t");
        if ($category_id) { $category_conditions = array('Categories.id' => $category_id); }
        

        // BUILD CSV
        // --------------------------------------------------------------------------
        $projects = $this->Projects
            ->find()
            ->select([
                'id',
                'name',
                'url',
                'created',
                'modified',
                'start_date',
                'finish_date',
                'description',
                'contribution',
                'contributing',
                'organization',
                'instance_id',
                'organization_type_id',
                'project_stage_id',
                'user_id',
                'country_id',
            ])
            ->select(TableRegistry::get('Users'))
            ->select(TableRegistry::get('ProjectStages'))
            ->select(TableRegistry::get('Countries'))
            ->contain([
                'Countries',
                'ProjectStages',
                'Users' => function ($q) use ($user_conditions) {
                   return $q
                        ->select(['Users.id', 'Users.genre_id'])
                        ->select(TableRegistry::get('Genres'))
                        ->where($user_conditions)
                        ->contain(['Genres']);
                },
                'Categories'
            ])
            ->where(['instance_id' => $instance->id])
            ->where($conditions)
            ->all();

        // $projects = $this->paginate(
        //     $this->Projects
        //         ->find()
        //         ->matching('Categories', function(\Cake\ORM\Query $q) use ($category_conditions) {
        //             return $q->where($category_conditions);
        //         })
        //         ->distinct(['Projects.id'])
        // );


        $data = [];
        foreach ($projects as $project) {
            // var_dump($project);

            // CATEGORIES (de mayor tamaño, sólo porsiacaso!)
            $category_ids = [];
            $categories_en = [null, null, null, null, null, null, null];
            $categories_es = [null, null, null, null, null, null, null];
            foreach ($project->categories as $idx => $category) {
                array_push($category_ids, $category->id);
                $categories_en[$idx] = $category->name;
                $categories_es[$idx] = $category->name_es;
            }

            // check for category id condition
            if ($category_id && !in_array($category_id, $category_ids)) {
                // do not process this project
                continue;
            }

            // CONTACT INFO
            $user_data = $this->App->getUserInstanceData($project->user->id, $instance->id);
            $contact = null;
            if ($user_data) {
                // get instance contact
                $contact = $user_data->contact;
            } else {
                // else: get general contact mail
                $user_system_data = $this->App->getUserInstanceData($project->user->id, $this->App->getAdminInstanceId());
                if ($user_system_data) {
                    $contact = $user_system_data->contact;
                }
            }

            // ORGANIZATION TYPE INFO
            $organization_type = TableRegistry::get('OrganizationTypes')
                ->find()
                ->where(['instance_id' => $instance->id])
                ->where(['id' => $project->organization_type_id])
                ->first();
                $organization_type_en = null;
                $organization_type_es = null;
            if ($organization_type) {
                $organization_type_en = $organization_type->name;
                $organization_type_es = $organization_type->name_es;
            }

            // COUNTRY CONTINENT INFO
            $continent_id = null;
            $continent_name_en = null;
            $continent_name_es = null;
            $subcontinent = TableRegistry::get('Subcontinents')
                ->find()
                ->where(['id' => $project->country->subcontinent_id])
                ->first();
            if ($subcontinent) {
                $continent = TableRegistry::get('Continents')
                    ->find()
                    ->where(['id' => $subcontinent->continent_id])
                    ->first();
                if ($continent) {
                    $continent_id = $continent->id;
                    $continent_name_en = $continent->name;
                    $continent_name_es = $continent->name_es;
                }
            }


            $row = [
                'id'   => $project->id,
                'name' => $project->name,
                'external_url'  => $project->url,
                'user_name'     => $project->user->name,
                'user_contact'  => $contact,
                'user_genre_en' => $project->user->genre->name,
                'user_genre_es' => $project->user->genre->name_es,
                'organization'  => $project->organization,
                'organization_type_en'  => $organization_type_en,
                'organization_type_es'  => $organization_type_es,
                'project_stage_en' => $project->project_stage->name,
                'project_stage_es' => $project->project_stage->name_es,
                'start_date'   => $project->start_date,
                'finish_date'   => $project->finish_date,
                'country_id'    => $project->country_id,
                'country_A3'    => $project->country->cod_a3,
                'country_name_en'    => $project->country->name,
                'country_name_es'    => $project->country->name_es,
                'country_continent_id'    => $continent->id,
                'country_continent_name_en'    => $continent_name_en,
                'country_continent_name_es'    => $continent_name_es,
                'description'   => $project->description,
                'contribution'   => $project->contribution,
                'contributing'   => $project->contributing,
                'created'   => $project->created,
                'modified'   => $project->modified,
                'category_1_en' => $categories_en[0],
                'category_1_es' => $categories_es[0],
                'category_2_en' => $categories_en[1],
                'category_2_es' => $categories_es[1],
                'category_3_en' => $categories_en[2],
                'category_3_es' => $categories_es[2],
                'category_4_en' => $categories_en[3],
                'category_4_es' => $categories_es[3],
            ];
            array_push($data, $row);
        }

        $_serialize = 'data';
        $_header = [
            'id',
            'name',
            'external_url',
            'user_name',
            'user_contact',
            'user_genre_en',
            'user_genre_es',
            'organization',
            'organization_type_en',
            'organization_type_es',
            'project_stage_en',
            'project_stage_es',
            'start_date',
            'finish_date',
            'country_id',
            'country_A3',
            'country_name_en',
            'country_name_es',
            'country_continent_id',
            'country_continent_name_en',
            'country_continent_name_es',
            'description',
            'contribution',
            'contributing',
            'created',
            'modified',
            'category_1_en',
            'category_1_es',
            'category_2_en',
            'category_2_es',
            'category_3_en',
            'category_3_es',
            'category_4_en',
            'category_4_es',
        ];
        // $_footer = ['Totals', '400', '$3000'];
        // formatting
        // $_delimiter = chr(9); //tab  // _delimiter: ,
        // $_enclosure = '"';  // _enclosure: "
        // $_newline = '\r\n';  // _newline: \n
        // $_eol = '~';  // _eol: \n
        // $_bom = true;  // _bom: false
        // _setSeparator: false
        // $_null defaults to ''.


        // File name
        $this->response->download($instance->namespace . '_export.csv');

        // CSV builder
        $this->viewBuilder()->className('CsvView.Csv');

        // required data
        $this->set(compact('data', '_serialize', '_header'));
        // '_footer', '_delimiter', '_enclosure', '_newline', '_eol', '_bom', '_enclosure'
    }

    /**
     * View method
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($instance_namespace = null, $id = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);

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

        $download_query = "p=" . $project->id;
        $this->set('download_query', $download_query);
        $this->set('project', $project);
        $this->set('instance', $instance);
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
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);

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
            ->where(['OrganizationTypes.name !=' => '[null]'])
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
            ->where(['ProjectStages.name !=' => '[null]'])
            ->order(['id' => 'ASC'])
            ->all();

        // Categories
        $categories = $this->Projects->Categories
            ->find('list', ['limit' => 200])
            ->where(['Categories.name !=' => '[null]'])
            ->where(['Categories.instance_id' => $instance->id])
            ->order(['name' => 'ASC'])
            ->all();


        // $users = $this->Projects->Users->find('list', ['limit' => 200]);
        // $cities = $this->Projects->Cities->find('list', ['limit' => 200]);

        $this->set('instance', $instance);
        $this->set(compact('project', 'organizationTypes', 'projectStages', 'countries', 'categories','instance'));
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
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);

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
            ->where(['OrganizationTypes.name !=' => '[null]'])
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
            ->where(['ProjectStages.name !=' => '[null]'])
            ->order(['id' => 'ASC'])
            ->all();

        // Categories
        $categories = $this->Projects->Categories
            ->find('list', ['limit' => 200])
            ->where(['Categories.name !=' => '[null]'])
            ->where(['Categories.instance_id' => $instance->id])
            ->order(['name' => 'ASC'])
            ->all();

        // $users = $this->Projects->Users->find('list', ['limit' => 200]);
        // $cities = $this->Projects->Cities->find('list', ['limit' => 200]);

        $this->set('instance', $instance);
        $this->set(compact('project', 'organizationTypes', 'projectStages', 'countries', 'categories', 'instance'));
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
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        $project = $this->Projects->get($id);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
    }
}
