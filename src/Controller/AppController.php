<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
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
            ]
        ]);
    }

    public function beforeFilter(Event $event)
    {
        // Deny all actions by default
        $this->Auth->deny();        

        // loginAction depends on instance or admin site
        // instance  : /instance_namespace/login
        // admin_site: /admin/login                    // router gives this as param [0]
        if (isset($this->request->params['pass']) && isset($this->request->params['pass'][0]) ) {
            $this->Auth->config('loginAction', [
                'controller' => 'Users',
                'action' => 'login',
                $this->request->params['pass'][0]
            ]);
        }

        // logged in users must be redirected to the related preview when 
        // trying to access to an unauthorized view
        $user = $this->Auth->user();
        if ($user) {

            // real ns
            $instance_namespace = TableRegistry::get('Instances')
                ->find()
                ->select(['id', 'namespace'])
                ->where(['id' => $user['instance_id']])
                ->first()
                ->namespace;
            // var_dump($instance_namespace);

            // this assumes that it will never be called for 'sys' ns's users,
            // because they have complete access.
            $this->Auth->config('unauthorizedRedirect', [
                'controller' => 'Instances',
                'action' => 'preview',
                $instance_namespace
            ]);
        }
        
    }

    public function isAuthorized($user)
    {
        // var_dump($user);
        // Admin can access every action
        if (!isset($user['role_id'])) {
            return false;
        }

        // sysadmin: complete access
        if ($user['role_id'] == '2') {
            return true;
        }

        // admin: complete access to instance pages
        if ($user['role_id'] == '1') {

            // when inside an instance, then the first parameter must be the $instance_namespace
            if (isset($this->request->params['pass']) && isset($this->request->params['pass'][0]) ) {
                
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
        }

        // other
        return false;
    }


    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
