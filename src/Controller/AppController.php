<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\I18n;
use App\View\Helper\LocHelper;

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
        I18n::locale('es');
    }

    public function beforeFilter(Event $event)
    {
        // Deny all actions by default
        $this->Auth->deny();        
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

        // manage user session
        $auth_user = $this->Auth->user();
        if ($auth_user) {

            // var_dump($auth_user);
            $this->set('auth_user', $auth_user);
        }
    }
}
