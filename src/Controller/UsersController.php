<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use RandomLib;

class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['view', 'add', 'logout', 'passwordRecovery', 'passwordReset']);
    }

    public function isAuthorized($user = null)
    {
        if (parent::isAuthorized($user)) { return true; }
        
        // can edit and delete himself
        if ($this->request->action == 'edit' || $this->request->action == 'delete') {
            $requested_id = $this->request->params['pass'][0];
            if ($requested_id == $user['id']) {
                return true;
            }
        }
        return false;
    }


    public function passwordReset() {
        // already logged in: redirect to home 
        if ($this->Auth->user()) {
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        // redirect to home... invalid get params
        $user_id = (int)$this->request->query("u");
        $random = $this->request->query("r");
        if (!$user_id || !$random) {
            //$this->Flash->error(__d("auth", "MISSING GET PARAMETERS"));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }


        // verify link time
        $users_recovery_table = TableRegistry::get('UsersRecovery');
        $users_recovery = $users_recovery_table->find()
            ->where(['user_id' => $user_id])
            ->first();
        if (!$users_recovery) {
            $users_recovery = $users_recovery_table->newEntity();
            // $this->Flash->error(__d("auth", "USER DOES NOT HAVE RECOVERY INFO"));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }
        if ($users_recovery->random != $random) {
            $this->Flash->error(__d("auth", "Your recovery key is invalid, request another one"));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }
        if (!$users_recovery->modified->wasWithinLast("3 days")) {
            $this->Flash->error(__d("auth", "This recovery key has expired, request another one"));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        // retrieve required user data
        $user = $this->Users->find()
            ->where(['Users.id' => $user_id])
            ->select(['id','name','email'])
            ->first();
        if (!$user) {
            //$this->Flash->error(__d("auth", "INVALID USER ID"));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        if ($this->request->is('post')) {

            if (!array_key_exists("repassword", $this->request->data)
                || !array_key_exists("password", $this->request->data)
                || $this->request->data["repassword"] != $this->request->data["password"]
                ) {
                $this->Flash->error(__d("auth", "Passwords must match!"));

            } else {

                $user_mod = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user_mod)) {

                    // single use key --> delete info
                    $users_recovery_table->delete($users_recovery);
                    
                    //////////////////////////////////////////////////////////////////////////
                    // send mail
                    //////////////////////////////////////////////////////////////////////////
                    $dvine_link = Router::url([
                        'controller' => 'Instances',
                        'action' => 'home',
                        '_full' => true
                    ]);
                    $text = "";
                    $subject = "";
                    if ($this->request->lang == "en") {
                        $subject = "DVINE WEB APP. Password recovery succeeded";
                        $text = "" .
                        "Hello " . $user->name . ",\n" .
                        "\n" .
                        "Your password for DVINE WEB APP (" . $dvine_link . ") has been updated.\n" .
                        "\n" .
                        "Please, don't reply to this message.\n" .
                        "\n" .
                        "Bye!\n" .
                        "dvine web app\n";
                    } else {
                        $subject = "DVINE WEB APP. Recuperación de contraseña exitoso";
                        $text = "" .
                        "Hola " . $user->name . ",\n" .
                        "\n" .
                        "Tu contraseña de DVINE WEB APP (" . $dvine_link . ") ha sido modificada correctamente.\n" .
                        "\n" .
                        "Por favor, no responda a este mensaje.\n" .
                        "\n" .
                        "Adios!\n" .
                        "dvine web app\n";
                    }
                    $email = new Email('default');
                    $email->from(['contacto@app.dvine.cl' => 'Contact Dvine Web App'])
                        ->to($user->email)
                        ->subject($subject)
                        ->send($text);

                    $this->Flash->success(__d("auth", 'Your password has been modified'));
                    $this->Auth->setUser($user_mod);
                    return $this->redirect(['controller' => 'Users', 'action' => 'view', $user_mod->id]);
                } else {
                    $this->Flash->error(__('There was an error. Please, try again.'));
                    foreach ($user_mod->errors() as $error) {
                        $this->Flash->error(__('{0}', reset($error)));
                    }
                } 
            }
        }
        

        $this->set('user', $user);
    }

    public function passwordRecovery() {
        // already logged in: redirect to home 
        if ($this->Auth->user()) {
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        if ($this->request->is('post')) {

            // ver que el mail sea un mail correcto
            if (array_key_exists("email", $this->request->data) && $this->request->data["email"] != "") {

                $validator = new Validator();
                $validator->email("email");
                $errors = $validator->errors($this->request->data);
                // $validator = TableRegistry::get('InstancesUsers')->validationDefault($validator);
                // $errors = $validator->errors($ui_data);
                if (empty($errors)) {

                    $email = $this->request->data["email"];

                    // retrieve required user data
                    $user = $this->Users->find()
                        ->where(['Users.email' => $email])
                        ->select(['id','name','email'])
                        ->first();
                    if (!$user) {
                        $this->Flash->error(__d("auth", "Sorry, we don't know an account with this email."));
                    } else {

                        $valid_chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                        $factory = new RandomLib\Factory;
                        $generator = $factory->getLowStrengthGenerator();
                        $random_string = $generator->generateString(128, $valid_chars);

                        // write DB
                        $users_recovery_table = TableRegistry::get('UsersRecovery');
                        $users_recovery = $users_recovery_table->find()
                            ->where(['user_id' => $user->id])
                            ->first();
                        if (!$users_recovery) {
                            $users_recovery = $users_recovery_table->newEntity();
                        }
                        $users_recovery->user_id = $user->id;
                        $users_recovery->random = $random_string;

                        if ($users_recovery_table->save($users_recovery)) {
                            // send email

                            $recovery_link = Router::url([
                                'controller' => 'Users',
                                'action' => 'passwordReset',
                                '?' => ['u' => $user->id, 'r' => $random_string],
                                '#' => 'top',
                                '_full' => true
                            ]);


                            $text = "";
                            $subject = "";
                            if ($this->request->lang == "en") {
                                $subject = "DVINE WEB APP. Password recovery";
                                $text = "" .
                                "Hello " . $user->name . ",\n" .
                                "\n" .
                                "Here is the link for the password recovery process you have just requested.\n" . 
                                "There you must provide a new password for your account.\n" .
                                "\n" .
                                $recovery_link . "\n" .
                                "\n" .
                                "If you have not requested a password reset, maybe someone is trying to access\n" .
                                "to your account. You can ignore this email.\n" .
                                "\n" .
                                "Please, don't reply to this message.\n" .
                                "\n" .
                                "Bye!\n" .
                                "dvine web app\n";
                            } else {
                                $subject = "DVINE WEB APP. Recuperación de contraseña";
                                $text = "" .
                                "Hola " . $user->name . ",\n" .
                                "\n" .
                                "Aquí está el link que pediste para recuperar la contraseña de tu cuenta. Ahí\n" .
                                "tendrás que introducir una nueva contraseña para tu cuenta.\n" .
                                "\n" .
                                $recovery_link . "\n" .
                                "\n" .
                                "Si tu no has pedido una recuperación de contraseña, puede ser que alguien\n" .
                                "esté intentando acceder a tu cuenta. Puedes ignorar este correo.\n" .
                                "\n" .
                                "Por favor, no responda a este mensaje.\n" .
                                "\n" .
                                "Adios!\n" .
                                "dvine web app\n";
                            }
                            $email = new Email('default');
                            $email->from(['contacto@app.dvine.cl' => 'Contact Dvine Web App'])
                                ->to($user->email)
                                ->subject($subject)
                                ->send($text);

                            $this->Flash->success(__d("auth", "Check your email, we have send you some instructions."));
                        } else {
                            $this->Flash->error(__d("auth", "An error ocurred, please try again"));
                        }
                    }
                } else {
                    $this->Flash->error(__d("auth", "The email address is invalid"));
                }
            } else {
                $this->Flash->error(__d("auth", "The email address cannot be empty"));
            }
        }
    }

    public function login()
    {
        // already logged in: redirect to home 
        if ($this->Auth->user()) {
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                // sysadmin is redirected to admin view
                if ($this->App->isSysadmin($user['id'])) {
                    return $this->redirect(['controller' => 'Instances', 'action' => 'index']);
                }
                // admin and users are redirected to home
                return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
            }
            $this->Flash->error(__d("auth", 'Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        // $user = $this->Auth->user();
        $this->Auth->logout();
        return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
    }


    public function view($id = null)
    {
        // retrieve required user data
        $user = $this->Users->find()
            ->where(['Users.id' => $id])
            ->select(['id','name','email','genre_id'])
            ->select($this->Users->Genres)
            ->contain([
                'Genres',
                'Projects',
                'Instances' => function ($q) {
                    return $q->select(['id', 'name', 'name_es', 'namespace', 'logo']);
                }
            ])
            ->first();
        if (!$user) {
            $this->Flash->error(__('This user does not exists'));
            return $this->redirect($this->referer());
        }

        // --  add remaining info --
        // contact
        $data = $this->App->getUserInstanceData($user->id, $this->App->getAdminInstanceId());
        if ($data) {
            $user->contact = $user->instances[0]->_joinData->contact;
        }
        // organization_type
        foreach ($user->instances as $idx => $instance) {
            $organization_type_id = $instance->_joinData->organization_type_id;
            $user->instances[$idx]->_joinData->organization_type = 
                $this->App->getOrganizationTypeById($instance->id, $organization_type_id);
        }

        // manage access by client
        $auth_client = $this->Auth->user();
        if ($auth_client) {
            // client is a logged in user
            $client_id = $auth_client['id'];
            if ($client_id == $user->id || $this->App->isSysadmin($client_id)) {
                $this->set('client_type', 'authorized');
            } else {
                $this->set('client_type', 'logged');
            }
            $this->set('client_id', $client_id);

        } else {
            // common client
            $this->set('client_type', 'visita');
        }
        // var_dump($user->instances);
        $this->set('user', $user);
    }

 
    public function add()
    {
        // register on Users and register on InstanceUsers
        $user = $this->Users->newEntity();
        $user_instance = TableRegistry::get('InstancesUsers')->newEntity();
        if ($this->request->is('post')) {

            // patch user
            $user = $this->Users->patchEntity($user, $this->request->data);

            // check passwords
            if (!array_key_exists("repassword", $this->request->data)
                || !array_key_exists("password", $this->request->data)
                || $this->request->data["repassword"] != $this->request->data["password"]
                ) {
                $this->Flash->error(__d("auth", "Passwords must match!"));

            } else {
                       
                // patch user->instance
                $ui_data = array();
                $ui_data = array_merge($ui_data, array('role_id'              => 0));
                $ui_data = array_merge($ui_data, array('contact'              => $user->contact));
                $ui_data = array_merge($ui_data, array('main_organization'    => '[null]'));
                $ui_data = array_merge($ui_data, array('organization_type_id' => 1));

                // validate contact mail
                $validator = new Validator();
                $validator = TableRegistry::get('InstancesUsers')->validationDefault($validator);
                $errors = $validator->errors($ui_data);
                if (empty($errors)) {

                    // save user
                    $user_instance = TableRegistry::get('InstancesUsers')->patchEntity($user_instance, $ui_data);
                    if ($this->Users->save($user)) {
                        
                        // save instances users
                        $user_instance->user_id = $user->id;
                        $user_instance->instance_id = $this->App->getAdminInstanceId();
                        if (TableRegistry::get('InstancesUsers')->save($user_instance)) {


                            //////////////////////////////////////////////////////////////////////////
                            // send mail
                            //////////////////////////////////////////////////////////////////////////
                            $dvine_link = Router::url([
                                'controller' => 'Instances',
                                'action' => 'home',
                                '_full' => true
                            ]);
                            $text = "";
                            $subject = "";
                            if ($this->request->lang == "en") {
                                $subject = "Welcome to DVINE WEB APP";
                                $text = "" .
                                "Hello " . $user->name . ",\n" .
                                "\n" .
                                "Welcome to DVINE WEB-APP (" . $dvine_link . "), a tool that\n" .
                                "helps to visualize and geolocalize projects in a given field.\n" .
                                "\n" .
                                "\n" .
                                "Please, don't reply to this message.\n" .
                                "\n" .
                                "Bye!\n" .
                                "dvine web app\n";
                            } else {
                                $subject = "Bienvenido a DVINE WEB APP";
                                $text = "" .
                                "Hola " . $user->name . ",\n" .
                                "\n" .
                                "Bienvenido a DVINE WEB-APP (" . $dvine_link . "), una herramienta\n" .
                                "que permite visualizar y geolocalizar proyectos a nivel global, en un campo determinado.\n" .
                                "\n" .
                                "\n" .
                                "Por favor, no responda a este mensaje.\n" .
                                "\n" .
                                "Adios!\n" .
                                "dvine web app\n";
                            }
                            
                            $email = new Email('default');
                            $email->from(['contacto@app.dvine.cl' => 'Contact Dvine Web App'])
                                ->to($user->email)
                                ->subject($subject)
                                ->send($text);

                            $this->Flash->success(__('Welcome ') . ' ' .  $user->name . '!');

                            // log the current user out!
                            $logged_user = $this->Auth->user();
                            if ($logged_user) { $this->Auth->logout(); }

                            // log the new user in
                            $this->Auth->setUser($user->toArray());
                            return $this->redirect(['controller' => 'InstancesUsers', 'action' => 'add', $user->id]);
                        } else {
                            foreach ($user_instance->errors() as $error) {
                                $this->Flash->error(__('{0}', reset($error)));
                            }
                        }
                    } else {
                        foreach ($user->errors() as $error) {
                            $this->Flash->error(__('{0}', reset($error)));
                        }
                    }
                } else{
                    foreach ($errors as $error) {
                        $this->Flash->error(__('{0}', reset($error)));
                    }
                }
            }
        }
        $genres = $this->Users->Genres
            ->find('list', ['limit' => 200])
            ->where(['Genres.name !=' => '[null]'])
            ->order(['name' => 'ASC']);

        $genres_es = $this->Users->Genres
            ->find('list', [
                'limit' => 200,
                'keyField' => 'id',
                'valueField' => 'name_es'
            ])
            ->where(['Genres.name !=' => '[null]'])
            ->order(['name_es' => 'ASC']);

        $this->set(compact('user', 'genres', 'genres_es'));
        $this->set('_serialize', ['user']);
    }


    public function edit($id = null)
    {
        $user = $this->Users->find()
            ->where(['id' => $id])
            ->first();
        if (!$user) {
            $this->Flash->error(__('This user does not exists'));
            return $this->redirect(['controller' => 'Instances', 'action' => 'home']);
        }

        $user_instance = $this->App->getUserInstanceData($id, $this->App->getAdminInstanceId());

        if ($this->request->is(['patch', 'post', 'put'])) {

            if (array_key_exists("email", $this->request->data)) {
                unset($this->request->data["email"]);
            }
            if (array_key_exists("id", $this->request->data)) {
                unset($this->request->data["id"]);
            }
            
            if (array_key_exists("password", $this->request->data) && $this->request->data["password"] == "") {
                unset($this->request->data["password"]);
            }
            // var_dump($this->request->data);


            // validate contact mail
            $ui_data = array();
            $ui_data = array_merge($ui_data, array('contact' => $this->request->data["contact"]));
            $validator = new Validator();
            $validator = TableRegistry::get('InstancesUsers')->validationContact($validator);
            $errors = $validator->errors($ui_data);
            if (empty($errors)) {

                $user_instance->contact = $this->request->data["contact"];
                if (TableRegistry::get('InstancesUsers')->save($user_instance)) {

                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('User details has been saved.'));
                        return $this->redirect(['controller' => 'Users', 'action' => 'view', $user->id]);
                    } else {
                        $this->Flash->error(__('There was an error. Please, try again.'));
                        foreach ($user->errors() as $error) {
                            $this->Flash->error(__('{0}', reset($error)));
                        }
                    }
                } else {
                    foreach ($user_instance->errors() as $error) {
                        $this->Flash->error(__('{0}', reset($error)));
                    }
                }
            } else{
                foreach ($errors as $error) {
                    $this->Flash->error(__('{0}', reset($error)));
                }
            }
        }

        
        // add contact info for display
        if ($user_instance) {
            $user->contact = $user_instance->contact;
        }
    
        $genres = $this->Users->Genres
            ->find('list', ['limit' => 200])
            ->where(['Genres.name !=' => '[null]'])
            ->order(['name' => 'ASC']);

        $genres_es = $this->Users->Genres
            ->find('list', [
                'limit' => 200,
                'keyField' => 'id',
                'valueField' => 'name_es'
            ])
            ->where(['Genres.name !=' => '[null]'])
            ->order(['name_es' => 'ASC']);

        $this->set(compact('user', 'genres', 'genres_es'));
        $this->set('_serialize', ['user']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        // delete user
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        $this->Auth->logout();
        $this->redirect(['controller' => 'Instances', 'action' => 'home']);
    }
}
