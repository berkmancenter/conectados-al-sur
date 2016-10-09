<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * Instances Controller
 *
 * @property \App\Model\Table\InstancesTable $Instances
 */
class InstancesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);        
        
        // public actions
        $this->Auth->allow(['home', 'dots', 'preview', 'map']);
    }

    public function isAuthorized($user) {
        
        if (parent::isAuthorized($user)) {
            return true;
        }

        if ($this->request->action == 'view' || $this->request->action == 'edit' || $this->request->action == 'delete') {
            $instance_namespace = $this->request->params['pass'][0];

            $instance = $this->App->getInstance($instance_namespace, false); // do not redirect
            if ($instance && $this->App->isAdmin($user['id'], $instance->id)) {
                return true;
            }
        }
        return false;
    }

    public function home()
    {
        $user = $this->Auth->user();
        if ($user) {

            if ($this->App->isSysadmin($user['id'])) {
                // return all instances
                $app_ns = $this->App->getAdminNamespace();
                $user_instances = TableRegistry::get('Instances')
                    ->find()
                    ->select(['id', 'name', 'name_es', 'namespace', 'logo'])
                    ->where(['namespace !=' => $app_ns])
                    ->all();

                $this->set('auth_user_instances', $user_instances);
            }
            else {
                // return associated instances
                $app_ns = $this->App->getAdminNamespace();
                $user_data = TableRegistry::get('Users')
                    ->find()
                    ->where(['id' => $user['id']])
                    ->contain([
                        'Instances' => function ($q) use ($app_ns) {
                            return $q
                                ->select(['id', 'name', 'namespace', 'logo'])
                                ->where(['Instances.namespace !=' => $app_ns]);
                        }
                    ])
                    ->first();
                if ($user_data) {
                    $user_instances = $user_data["instances"];
                    $this->set('auth_user_instances', $user_instances);
                }
            }
        }
    }


    public function index()
    {
        $app_ns = $this->App->getAdminNamespace();

        $query = $this->Instances
            ->find()
            ->select(['id', 'name', 'name_es', 'namespace', 'logo'])
            ->where(['namespace !=' => $app_ns]); // block sys
        $instances = $this->paginate($query);


        $sysadmins = TableRegistry::get('Users')
            ->find()
            ->select(['id', 'name', 'email'])
            ->matching('Instances', function ($q) use ($app_ns) {
                return $q
                    ->where(['Instances.namespace' => $app_ns])
                    ->where(['role_id' => 1]);
            })
            ->all();

        $this->set('sysadmins', $sysadmins);
        $this->set(compact('instances'));
        // $this->set('_serialize', ['instances']);
    }


    public function preview($instance_namespace = null)
    {
        // block sys instance
        if ($this->App->isAdminInstance($instance_namespace)) {
            $this->redirect($this->referer());
        }
        
        $instance = $this->App->getInstance($instance_namespace);
        // $this->App->setInstanceViewData($instance);

        $this->set('instance', $instance);
    }

    
    public function dots($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }
        
        $instance = $this->Instances
            ->find()
            ->select(['id', 'name', 'name_es', 'namespace', 'logo'])
            ->where(['Instances.namespace' => $instance_namespace])
            ->contain([])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        $this->set('instance', $instance);
        // $this->set(compact('instance', 'instance_namespace'));
        // $this->set('_serialize', ['instance']);
    }

 
    public function map($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        // ----- instance independent data --------

        // location data
        // available continents
        $continents = TableRegistry::get('Continents')
            ->find()
            ->where(['Continents.id !=' => '0'])
            ->all();
        // var_dump($continents);

        // available subcontinents
        $subcontinents = TableRegistry::get('Subcontinents')
            ->find()
            ->where(['Subcontinents.id !=' => '0'])
            ->all();
        // var_dump($subcontinents);

        // available countries
        $countries = TableRegistry::get('Countries')
            ->find()
            ->where(['Countries.id !=' => '0'])
            ->all();
        // var_dump($countries);

        // available genres
        $genres = TableRegistry::get('Genres')
            ->find()
            ->where(['Genres.name !=' => '[null]'])
            ->all();

        // available project_stages
        $project_stages = TableRegistry::get('ProjectStages')
            ->find()
            ->where(['ProjectStages.name !=' => '[null]'])
            ->all();
        
        // var_dump($genres);
        // var_dump($project_stages);


        // ----- instance dependent data --------
        // instance data
        $instance = $this->Instances
            ->find()
            ->where(['Instances.namespace' => $instance_namespace])
            ->contain([
                'OrganizationTypes' => function ($q) {
                   return $q->where(['OrganizationTypes.name !=' => '[null]']);
                },
                'Categories' => function ($q) {
                   return $q->where(['Categories.name !=' => '[null]']);
                }
            ])
            ->first();
        if (!$instance) {
            // $this->Flash->error(__('Invalid instance'));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }
        // available categories
        // var_dump($instance->categories);

        $projects = TableRegistry::get('Projects')
            ->find()
            ->where(['Projects.instance_id' => $instance->id])
            ->select([
                    'id', 'name', 'user_id', 'instance_id', 'description',
                     'organization', 'organization_type_id', 'project_stage_id',
                     'country_id', 'city_id', 'latitude', 'longitude', 'created',
                     'modified', 'start_date', 'finish_date'
                ])
            ->contain([
                    'Users' => function ($q) {
                       return $q->select(['Users.genre_id']);
                    },
                    'Categories' => function ($q) {
                        return $q->select(['Categories.id']);
                    },
                ])
            ->all();
        // ->first();
        // var_dump($projects->categories);

        // filter trick
        $countries_f = TableRegistry::get('Countries')
            ->find('list')
            ->where(['Countries.id !=' => '0'])
            ->order(['name' =>'ASC'])
            ->all();
        $genres_f = TableRegistry::get('Genres')
            ->find('list')
            ->where(['Genres.name !=' => '[null]'])
            ->order(['name' =>'ASC'])
            ->all();
        $project_stages_f = TableRegistry::get('ProjectStages')
            ->find('list')
            ->where(['ProjectStages.name !=' => '[null]'])
            ->all();
        $_categories = $this->Instances->Categories
            ->find('list')
            ->where(['Categories.name !=' => '[null]'])
            ->where(['Categories.instance_id' => $instance->id])
            ->order(['name' =>'ASC'])
            ->all();
        $_organization_types = $this->Instances->OrganizationTypes
            ->find('list')
            ->where(['OrganizationTypes.name !=' => '[null]'])
            ->where(['OrganizationTypes.instance_id' => $instance->id])
            ->order(['name' =>'ASC'])
            ->all();
        $continents_f = TableRegistry::get('Continents')
            ->find('list')
            ->where(['Continents.id !=' => '0'])
            ->all();
        $subcontinents_f = TableRegistry::get('Subcontinents')
            ->find('list')
            ->where(['Subcontinents.id !=' => '0'])
            ->all();

        $this->set('continents_f', $continents_f);
        $this->set('subcontinents_f', $subcontinents_f);
        $this->set('countries_f', $countries_f);
        $this->set('genres_f', $genres_f);
        $this->set('project_stages_f', $project_stages_f);
        $this->set('_organization_types', $_organization_types);
        $this->set('_categories', $_categories);

        // independent data
        $this->set('genres', $genres);
        $this->set('project_stages', $project_stages);

        // instance data
        $this->set('instance', $instance);
        $this->set('projects', $projects);
        $this->set('continents', $continents);
        $this->set('subcontinents', $subcontinents);
        $this->set('countries', $countries);
        // $this->set(compact('projects', 'instance_namespace'));
        // $this->set('_serialize', ['projects']);
        
    }



    public function view($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }

        $instance = $this->Instances
            ->find()
            ->contain([
                'OrganizationTypes' => function ($q) {
                   return $q->where(['OrganizationTypes.name !=' => '[null]']);
                },
                'Categories' => function ($q) {
                   return $q->where(['Categories.name !=' => '[null]']);
                }
            ])
            ->where(['Instances.namespace' => $instance_namespace])
            ->first();
        if (!$instance) {
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        $app_ns = $this->App->getAdminNamespace();
        $sysadmins = TableRegistry::get('Users')
            ->find()
            ->select(['id', 'name', 'email'])
            ->matching('Instances', function ($q) use ($app_ns) {
                return $q
                    ->where(['Instances.namespace' => $app_ns])
                    ->where(['role_id' => 1]);
            })
            ->all();
        // var_dump($sysadmins);

        $all_admins = TableRegistry::get('Users')
            ->find()
            ->select(['id', 'name', 'email'])
            ->matching('Instances', function ($q) use ($instance_namespace) {
                return $q
                    ->where(['Instances.namespace' => $instance_namespace])
                    ->where(['role_id' => 1]);
            })
            ->all();
        $admins = $all_admins->filter(function ($admin, $key) {
            return !$this->App->isSysadmin($admin->id);
        });

        $this->paginate = [
            'limit'      => 10
        ];
        $users = $this->paginate(
            TableRegistry::get('Users')
                ->find()
                ->select(['id', 'name', 'email'])
                ->matching('Instances', function ($q) use ($instance_namespace) {
                    return $q
                        ->where(['Instances.namespace' => $instance_namespace])
                        ->where(['role_id' => 0]);
                })
        );
        // var_dump($users);

        // var_dump($instance->sysadmins);

        $this->set('users', $users);
        $this->set('admins', $admins);
        $this->set('sysadmins', $sysadmins);
        $this->set('instance', $instance);
        // $this->set('_serialize', ['instance']);

        // manage access by client
        $auth_client = $this->Auth->user();
        if ($auth_client && $this->App->isSysadmin($auth_client['id'])) {
            $this->set('client_type', 'sysadmin');
        } else {
            // common client (should not happen!)
            $this->set('client_type', 'other');
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }
    }

 
    public function add()
    {
        $instance = $this->Instances->newEntity();
        if ($this->request->is('post')) {

            $instance->use_org_types = true;
            $instance->use_user_genre = true;
            $instance->use_user_organization = true;
            $instance->use_proj_cities = true;
            $instance->use_proj_stage = true;
            $instance->use_proj_categories = true;
            $instance->use_proj_description = true;
            $instance->use_proj_url = true;
            $instance->use_proj_contribution = true;
            $instance->use_proj_contributing = true;
            $instance->use_proj_organization = true;
            $instance->use_proj_location = true;
            $instance->use_proj_dates = true;
            $instance->proj_max_categories = 4;

            $instance = $this->Instances->patchEntity($instance, $this->request->data);
            if ($this->Instances->save($instance)) {

                $dummy_category = TableRegistry::get('Categories')->newEntity();
                $dummy_category->name    = '[null]';
                $dummy_category->name_es = '[null]';
                $dummy_category->instance_id = $instance->id;

                $dummy_orgtype = TableRegistry::get('OrganizationTypes')->newEntity();
                $dummy_orgtype->name    = '[null]';
                $dummy_orgtype->name_es = '[null]';
                $dummy_orgtype->instance_id = $instance->id;

                $ok = true;
                if (!TableRegistry::get('Categories')->save($dummy_category)) {
                    foreach ($dummy_category->errors() as $error) {
                        $this->Flash->error(__('{0}', reset($error)));
                    }
                    $ok = false;
                }
                if (!TableRegistry::get('OrganizationTypes')->save($dummy_orgtype)) {
                    foreach ($dummy_orgtype->errors() as $error) {
                        $this->Flash->error(__('{0}', reset($error)));
                    }
                    $ok = false;
                }

                if ($ok) {
                    $this->Flash->success(__('The app has been saved.'));
                    return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance->namespace]);
                } else {
                    $this->Flash->error(__('There was an error while trying to generate some app data.'));
                    return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance->namespace]);
                }
            } else {
                $this->Flash->error(__('The app could not be saved. Please, try again.'));
                foreach ($instance->errors() as $error) {
                    $this->Flash->error(__('{0}', reset($error)));
                }
            }
        }
        $this->set(compact('instance'));
        $this->set('_serialize', ['instance']);
    }



    public function edit($instance_namespace = null)
    {
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }
        $instance = $this->App->getInstance($instance_namespace);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            // do not remove logo if not provided!
            if (isset($this->request->data['logo']) 
                && isset($this->request->data['logo']['name']) 
                && empty($this->request->data['logo']['name']) ) {
                unset($this->request->data['logo']);
            }
            $instance = $this->Instances->patchEntity($instance, $this->request->data);

            if ($this->Instances->save($instance)) {
                $this->Flash->success(__('The app data has been saved.'));
                return $this->redirect(['controller' => 'Instances', 'action' => 'view', $instance->namespace]);
            } else {
                $this->Flash->error(__('The app data could not be saved. Please, try again.'));
                foreach ($instance->errors() as $error) {
                    $this->Flash->error(__('{0}', reset($error)));
                }

                // clear errors
                $instance = $this->App->getInstance($instance_namespace);
            }
        }
        $this->set(compact('instance'));
        $this->set('_serialize', ['instance']);
    }


    public function delete($instance_namespace = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        // block sys instance
        if ($instance_namespace == $this->App->getAdminNamespace()) { $this->redirect($this->referer()); }
        $instance = $this->App->getInstance($instance_namespace);
 
        if ($this->Instances->delete($instance)) {
            $this->Flash->success(__('The app "{0}" has been deleted.', $instance->name));
        } else {
            $this->Flash->error(__('The app could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Instances', 'action' => 'index']);
    }
}
