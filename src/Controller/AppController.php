<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\I18n;
use App\View\Helper\LocHelper;
use Cake\Routing\Router;

class AppController extends Controller
{
    var $locHelper;
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password']
                ]
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Instances',
                'action' => 'home'
            ],
            'loginAction', [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);

        // custom components
        $this->loadComponent('App');
        
        // i18n
        $this->locHelper = new LocHelper(new \Cake\View\View());
    }

    public function beforeFilter(Event $event)
    {
        // Deny all actions by default
        $this->Auth->deny();

        // var_dump($this->request->lang);
        if ($this->request->lang && $this->request->lang == 'es') {
            I18n::locale('es');
        } else {
            I18n::locale('en_US');
        }
    }

    public function isAuthorized($user)
    {
        if (!isset($user['id'])) { return false; }

        // sysadmin: complete access
        if ($this->App->isSysadmin($user['id'])) {
            return true;
        }

        // other
        return false;
    }


    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        

        // handle language selection
        $base_url = Router::url('/');
        $here_url = $this->request->here;
        $no_lang_url = substr($this->request->here, strlen($base_url));
        $lang_current     = "en";
        $lang_alternative = "es";
        if ($this->request->lang) {
            $no_lang_url = substr($no_lang_url, 3);
            if ($this->request->lang == "es") {
                $lang_alternative = "en";
                $lang_current     = "es";
            }
        }
        $new_here_url = $base_url . $lang_alternative . "/" . $no_lang_url;
        $url_lang  =  substr($this->request->here, strlen($base_url));
        $this->set('lang_current', $lang_current);
        $this->set('lang_alternative', $lang_alternative);
        $this->set('lang_new_url', $new_here_url);
        // var_dump($base_url);
        // var_dump($here_url);
        // var_dump($no_lang_url);
        // var_dump($new_here_url);


        // manage user session
        $auth_user = $this->Auth->user();
        if ($auth_user) {

            // var_dump($auth_user);
            $this->set('auth_user', $auth_user);
        }
    }
}
