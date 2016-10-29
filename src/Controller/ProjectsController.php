<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\I18n\Date;

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
        
        // All registered users can add projects to their app!
        if ($this->request->action === 'add') {
            $instance_namespace = $this->request->params['pass'][0];
            $instance = $this->App->getInstance($instance_namespace, false); // do not redirect
            if ($this->App->isUserRegistered($user['id'], $instance->id)) {
                return true;
            }
        }

        // The project owner or an app admin can edit and delete it
        if (in_array($this->request->action, ['edit', 'delete'])) {

            $instance_namespace = (int)$this->request->params['pass'][0];
            $project_id         = (int)$this->request->params['pass'][1];
            $instance = $this->App->getInstance($instance_namespace, false); // do not redirect

            if (
                $this->Projects->isOwnedBy($project_id, $user['id']) ||
                ($instance && $this->App->isAdmin($user['id'], $instance->id))
            ) {
                return true;
            }
        }
        return false;
    }



    public function index($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);

        $user_conditions = array();
        $category_conditions = array();
        $conditions = array('Projects.instance_id' => $instance->id);

        // region_id && country_id
        $region_id = (int)$this->request->query("r");
        $country_id = (int)$this->request->query("c");

        $valid_subcontients = [];
        if ($region_id && $country_id) {        // both => country
            array_push($conditions, array('Projects.country_id' => $country_id));
        } elseif ($region_id && !$country_id) { // only region
            $continent = TableRegistry::get('Continents')
                ->find()
                ->where(['Continents.id =' => $region_id])
                ->first();
            if ($continent) {
                $this->set("filter_continent", $continent);

                $subcontinents = TableRegistry::get('Subcontinents')
                    ->find()
                    ->select('id', 'continent_id')
                    ->where(['continent_id' => $region_id])
                    ->extract('id')->toArray();
                if ($subcontinents) {
                    $valid_subcontients = $subcontinents;
                    // var_dump($valid_subcontients);
                }
            }

            // var_dump($continent);
        } elseif (!$region_id && $country_id) { // only country
            array_push($conditions, array('Projects.country_id' => $country_id));
        } else {
            // do nothing
        }

        if ($country_id) {
            $country = TableRegistry::get('Countries')
                ->find()
                ->where(['id =' => $country_id])
                ->first();
            array_push($conditions, array('Projects.country_id' => $country_id));
            if ($country) {
                $this->set("filter_country", $country);
            }
        }

        // organization_type_id
        $organization_type_id = (int)$this->request->query("o");
        if ($organization_type_id) {
            $orgtype = TableRegistry::get('OrganizationTypes')
                ->find()
                ->where(['id =' => $organization_type_id])
                ->where(['instance_id' => $instance->id])
                ->first();
            array_push($conditions, array('Projects.organization_type_id' => $organization_type_id));
            if ($orgtype) {
                $this->set("filter_orgtype", $orgtype);
            }
        }

        // project_stage_id
        $project_stage_id = (int)$this->request->query("s");
        if ($project_stage_id) {
            $stage = TableRegistry::get('ProjectStages')
                ->find()
                ->where(['id =' => $project_stage_id])
                ->first();
            array_push($conditions, array('Projects.project_stage_id' => $project_stage_id));
            if ($stage) {
                $this->set("filter_project_stage", $stage);
            }
        }

        // genre_id
        $genre_id = (int)$this->request->query("g");
        if ($genre_id) {
            $genre = TableRegistry::get('Genres')
                ->find()
                ->where(['id =' => $genre_id])
                ->first();
            $user_conditions = array('genre_id' => $genre_id);
            if ($genre) {
                $this->set("filter_genre", $genre);
            }
        }

        // category_id
        $category_id = (int)$this->request->query("t");
        if ($category_id) {
            $category = TableRegistry::get('Categories')
                ->find()
                ->where(['id =' => $category_id])
                ->where(['instance_id' => $instance->id])
                ->first();
            $category_conditions = array('Categories.id' => $category_id);
            if ($category && $category->name != "[null]") {
                $this->set("filter_category", $category);
            }
        }
        

        $this->paginate = [
            'limit'      => 10,
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
                    if ($category_conditions) {
                        return $q->where($category_conditions);
                    }
                    return $q;
                })
                ->matching('Countries', function(\Cake\ORM\Query $q) use ($valid_subcontients) {
                    if ($valid_subcontients) {
                        return $q->where(
                            function ($exp, $q) use ($valid_subcontients) {
                                return $exp->in('subcontinent_id', $valid_subcontients);
                            }
                        );
                    }
                    return $q;
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

        // region_id && country_id
        $region_id = (int)$this->request->query("r");
        $country_id = (int)$this->request->query("c");

        $valid_subcontients = [];
        if ($region_id && $country_id) {        // both => country
            array_push($conditions, array('Projects.country_id' => $country_id));
        } elseif ($region_id && !$country_id) { // only region
            $continent = TableRegistry::get('Continents')
                ->find()
                ->where(['Continents.id =' => $region_id])
                ->first();
            if ($continent) {
                $this->set("filter_continent", $continent);

                $subcontinents = TableRegistry::get('Subcontinents')
                    ->find()
                    ->select('id', 'continent_id')
                    ->where(['continent_id' => $region_id])
                    ->extract('id')->toArray();
                if ($subcontinents) {
                    $valid_subcontients = $subcontinents;
                    // var_dump($valid_subcontients);
                }
            }

            // var_dump($continent);
        } elseif (!$region_id && $country_id) { // only country
            array_push($conditions, array('Projects.country_id' => $country_id));
        } else {
            // do nothing
        }

        if ($country_id) {
            $country = TableRegistry::get('Countries')
                ->find()
                ->where(['id =' => $country_id])
                ->first();
            array_push($conditions, array('Projects.country_id' => $country_id));
            if ($country) {
                $this->set("filter_country", $country);
            }
        }

        // organization_type_id
        $organization_type_id = (int)$this->request->query("o");
        if ($organization_type_id) {
            $orgtype = TableRegistry::get('OrganizationTypes')
                ->find()
                ->where(['id =' => $organization_type_id])
                ->where(['instance_id' => $instance->id])
                ->first();
            array_push($conditions, array('Projects.organization_type_id' => $organization_type_id));
            if ($orgtype) {
                $this->set("filter_orgtype", $orgtype);
            }
        }

        // project_stage_id
        $project_stage_id = (int)$this->request->query("s");
        if ($project_stage_id) {
            $stage = TableRegistry::get('ProjectStages')
                ->find()
                ->where(['id =' => $project_stage_id])
                ->first();
            array_push($conditions, array('Projects.project_stage_id' => $project_stage_id));
            if ($stage) {
                $this->set("filter_project_stage", $stage);
            }
        }

        // genre_id
        $genre_id = (int)$this->request->query("g");
        if ($genre_id) {
            $genre = TableRegistry::get('Genres')
                ->find()
                ->where(['id =' => $genre_id])
                ->first();
            $user_conditions = array('genre_id' => $genre_id);
            if ($genre) {
                $this->set("filter_genre", $genre);
            }
        }

        // category_id
        $category_id = (int)$this->request->query("t");
        if ($category_id) {
            $category = TableRegistry::get('Categories')
                ->find()
                ->where(['id =' => $category_id])
                ->where(['instance_id' => $instance->id])
                ->first();
            $category_conditions = array('Categories.id' => $category_id);
            if ($category && $category->name != "[null]") {
                $this->set("filter_category", $category);
            }
        }

        // project id
        $project_id = (int)$this->request->query("p");
        if ($project_id) {
            array_push($conditions, array('Projects.id' => $project_id));
        }


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
            ->matching('Countries', function(\Cake\ORM\Query $q) use ($valid_subcontients) {
                    if ($valid_subcontients) {
                        return $q->where(
                            function ($exp, $q) use ($valid_subcontients) {
                                return $exp->in('subcontinent_id', $valid_subcontients);
                            }
                        );
                    }
                    return $q;
                })
            ->distinct(['Projects.id'])
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

        $is_authorized = false;
        $user = $this->Auth->user();
        if ($user) {
            if (
                $this->Projects->isOwnedBy($id, $user['id']) ||
                $this->App->isAdmin($user['id'], $instance->id) ||
                $this->App->isSysadmin($user['id'])
            ) {
                $is_authorized = true;
            }
        }
        $this->set('is_authorized', $is_authorized);

        $download_query = "p=" . $project->id;
        $this->set('download_query', $download_query);
        $this->set('project', $project);
        $this->set('instance', $instance);
        $this->set('_serialize', ['project']);
        
    }


    public function add($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);

        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {

            $output_date_format = "Y-m-d";
            $incomming_date_format = "M/dd/yy";
            if ($this->request->lang == "es") {
                $incomming_date_format = "dd/M/yy";
            }
            
            if (isset($this->request->data['start_date'])) {

                $old_date = $this->request->data['start_date'];
                if ($old_date == "") {
                    unset($this->request->data['finish_date']);
                } else {
                    $datetime = Date::parseDate($old_date, $incomming_date_format);
                    $new_date = $datetime->format($output_date_format);
                    $this->request->data['start_date'] = $new_date;
                }
            }
            if (isset($this->request->data['finish_date'])) {
                $old_date = $this->request->data['finish_date'];
                if ($old_date == "") {
                    unset($this->request->data['finish_date']);
                } else {
                    $datetime = Date::parseDate($old_date, $incomming_date_format);
                    $new_date = $datetime->format($output_date_format);
                    $this->request->data['finish_date'] = $new_date;
                }
            }

            $project = $this->Projects->patchEntity($project, $this->request->data);
            $project->instance_id = $instance->id;

            $client = $this->Auth->user();
            if (!$client) {
                return $this->redirect(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]);
            }
            $project->user_id = $client['id'];

            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['controller' => 'Projects', 'action' => 'view', $instance_namespace, $project->id]);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
                // $this->Flash->error($this->locHelper->crudAddError($loc_field));
                foreach ($project->errors() as $error) {
                    $this->Flash->error(__('{0}', reset($error)));
                }
            }
        }

        // filter trick
        $field_loc = "name";
        if ($this->request->lang == "es") {
            $field_loc = "name_es";
        }

        // OrganizationTypes
        $organizationTypes = $this->Projects->OrganizationTypes
            ->find('list', [
                'keyField' => 'id',
                'valueField' => $field_loc
            ])
            ->where(['OrganizationTypes.name !=' => '[null]'])
            ->where(['OrganizationTypes.instance_id' => $instance->id])
            ->order([$field_loc =>'ASC'])
            ->all();
            
        // countries
        $countries = $this->Projects->Countries
            ->find('list', [
                'keyField' => 'id',
                'valueField' => $field_loc
            ])
            ->where(['Countries.id !=' => '0'])
            ->order([$field_loc =>'ASC'])
            ->all();

        // ProjectStages
        $projectStages = $this->Projects->ProjectStages
            ->find('list', [
                    'keyField' => 'id',
                    'valueField' => $field_loc
                ])
            ->where(['ProjectStages.name !=' => '[null]'])
            ->order(['id' => 'ASC'])
            ->all();

        // Categories
        $categories = $this->Projects->Categories
            ->find('list', [
                'keyField' => 'id',
                'valueField' => $field_loc
            ])
            ->where(['Categories.name !=' => '[null]'])
            ->where(['Categories.instance_id' => $instance->id])
            ->order([$field_loc =>'ASC'])
            ->all();


        // $users = $this->Projects->Users->find('list', ['limit' => 200]);
        // $cities = $this->Projects->Cities->find('list', ['limit' => 200]);

        $this->set('instance', $instance);
        $this->set(compact('project', 'organizationTypes', 'projectStages', 'countries', 'categories','instance'));
        $this->set('_serialize', ['project']);
    }


    public function edit($instance_namespace = null, $id = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // get instance
        $instance = $this->App->getInstance($instance_namespace);

        $project = $this->Projects->get($id, [
            'contain' => ['Categories']
        ]);
        // var_dump($project->finish_date);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $output_date_format = "Y-m-d";
            $incomming_date_format = "M/dd/yy";
            if ($this->request->lang == "es") {
                $incomming_date_format = "dd/M/yy";
            }
            
            if (isset($this->request->data['start_date'])) {

                $old_date = $this->request->data['start_date'];
                if ($old_date == "") {
                    unset($this->request->data['finish_date']);
                } else {
                    $datetime = Date::parseDate($old_date, $incomming_date_format);
                    $new_date = $datetime->format($output_date_format);
                    $this->request->data['start_date'] = $new_date;
                }
            }
            if (isset($this->request->data['finish_date'])) {
                $old_date = $this->request->data['finish_date'];
                if ($old_date == "") {
                    unset($this->request->data['finish_date']);
                } else {
                    $datetime = Date::parseDate($old_date, $incomming_date_format);
                    $new_date = $datetime->format($output_date_format);
                    $this->request->data['finish_date'] = $new_date;
                }
            }
         
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['controller' => 'Projects', 'action' => 'view', $instance_namespace, $id]);
            } else {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
                foreach ($project->errors() as $error) {
                    $this->Flash->error(__('{0}', reset($error)));
                }
                // set variables for reedit
                if (isset($this->request->data['name']))          { $project->name         = $this->request->data['name'];         }
                if (isset($this->request->data['url']))           { $project->url          = $this->request->data['url'];          }
                if (isset($this->request->data['organization']))  { $project->organization = $this->request->data['organization']; }
                if (isset($this->request->data['start_date']))    { $project->start_date   = $this->request->data['start_date'];   }
                if (isset($this->request->data['finish_date']))   { $project->finish_date  = $this->request->data['finish_date'];  }
                if (isset($this->request->data['description']))   { $project->description  = $this->request->data['description'];  }
                if (isset($this->request->data['contribution']))  { $project->contribution = $this->request->data['contribution']; }
                if (isset($this->request->data['contributing']))  { $project->contributing = $this->request->data['contributing']; }
            }
        }

        // filter trick
        $field_loc = "name";
        if ($this->request->lang == "es") {
            $field_loc = "name_es";    
        }

        // OrganizationTypes
        $organizationTypes = $this->Projects->OrganizationTypes
            ->find('list', [
                'keyField' => 'id',
                'valueField' => $field_loc
            ])
            ->where(['OrganizationTypes.name !=' => '[null]'])
            ->where(['OrganizationTypes.instance_id' => $instance->id])
            ->order([$field_loc =>'ASC'])
            ->all();
            
        // countries
        $countries = $this->Projects->Countries
            ->find('list', [
                'keyField' => 'id',
                'valueField' => $field_loc
            ])
            ->where(['Countries.id !=' => '0'])
            ->order([$field_loc =>'ASC'])
            ->all();

        // ProjectStages
        $projectStages = $this->Projects->ProjectStages
            ->find('list', [
                    'keyField' => 'id',
                    'valueField' => $field_loc
                ])
            ->where(['ProjectStages.name !=' => '[null]'])
            ->order(['id' => 'ASC'])
            ->all();

        // Categories
        $categories = $this->Projects->Categories
            ->find('list', [
                'keyField' => 'id',
                'valueField' => $field_loc
            ])
            ->where(['Categories.name !=' => '[null]'])
            ->where(['Categories.instance_id' => $instance->id])
            ->order([$field_loc =>'ASC'])
            ->all();

        // var_dump($project->categories);
        // $users = $this->Projects->Users->find('list', ['limit' => 200]);
        // $cities = $this->Projects->Cities->find('list', ['limit' => 200]);

        $this->set('instance', $instance);
        $this->set(compact('project', 'organizationTypes', 'projectStages', 'countries', 'categories', 'instance'));
        $this->set('_serialize', ['project']);
    }


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
