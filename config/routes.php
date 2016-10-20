<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;


Router::defaultRouteClass('DashedRoute');

Router::addUrlFilter(function ($params, $request) {
    if (isset($request->params['lang']) && !isset($params['lang'])) {
        $params['lang'] = $request->params['lang']; // use previous lang
    } else if (!isset($params['lang'])) {
        $params['lang'] = 'en'; // default language
    }

    // forbid other languages
    if (isset($request->params['lang']) &&
       !in_array($request->params['lang'], ['en', 'es'])) 
    {
        unset($params['lang']);
    }
    return $params;
});


Router::scope('/:lang', function ($routes) {
    
    # home
    $routes->connect('/', ['controller' => 'Instances', 'action' => 'home']);

    # =================================================================================
    # STATIC PAGES
    # =================================================================================
    $routes->connect('/licence', ['controller' => 'Pages', 'action' => 'display', 'Licence']);
    $routes->connect('/privacy', ['controller' => 'Pages', 'action' => 'display', 'PrivacyPolicy']);
    $routes->connect('/contact', ['controller' => 'Contact', 'action' => 'contact']);


    # =================================================================================
    # users interaction
    # =================================================================================

    # login, logout, sign-up
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/sign-up', ['controller' => 'Users', 'action' => 'add']);

    # view
    $routes->connect('/users/:id', ['controller' => 'Users', 'action' => 'view'],
        ['pass' => ['id'], 'id' => '[0-9]+']
    );
        
    # edit
    $routes->connect(
        '/users/:id/edit',
        ['controller' => 'Users', 'action' => 'edit'],
        ['pass' => ['id'],'id' => '[0-9]+']
    );

    # delete
    $routes->connect(
        '/users/:id/delete',
        ['controller' => 'Users', 'action' => 'delete'],
        ['pass' => ['id'],'id' => '[0-9]+']
    );

    # =================================================================================
    # instances_users interaction
    # =================================================================================

    # add
    $routes->connect(
        '/users/:id/add_profile',
        ['controller' => 'InstancesUsers', 'action' => 'add'],
        ['pass' => ['id'],'id' => '[0-9]+']
    );

    # edit
    $routes->connect(
        '/users/:id/edit_profile/:instance_namespace',
        ['controller' => 'InstancesUsers', 'action' => 'edit'],
        [
            'pass' => ['id', 'instance_namespace'],
            'id' => '[0-9]+'
        ]
    );

    # delete
    $routes->connect(
        '/users/:id/delete_profile/:instance_namespace',
        ['controller' => 'InstancesUsers', 'action' => 'delete'],
        [
            'pass' => ['id', 'instance_namespace'],
            'id' => '[0-9]+'
        ]
    );
    


    # =================================================================================
    # sysadmin page
    # =================================================================================
    # Instances Controller
    # -------------------------------------------------------------------------
    $routes->connect('/admin',     ['controller' => 'Instances', 'action' => 'index']);
    $routes->connect('/admin/add', ['controller' => 'Instances', 'action' => 'add'  ]);


    # =================================================================================
    # admin page
    # =================================================================================

    # Instances Controller
    # -------------------------------------------------------------------------
    # view
    $routes->connect(
        '/:instance_namespace/admin',
        ['controller' => 'Instances', 'action' => 'view'],
        ['pass' => ['instance_namespace']]
    );

    # edit
    $routes->connect(
        '/:instance_namespace/admin/edit',
        ['controller' => 'Instances', 'action' => 'edit'],
        ['pass' => ['instance_namespace']]
    );

    # delete
    $routes->connect(
        '/:instance_namespace/admin/delete',
        ['controller' => 'Instances', 'action' => 'delete'],
        ['pass' => ['instance_namespace']]
    );

    # csv export
    $routes->connect(
        '/:instance_namespace/admin/download_user_list',
        ['controller' => 'Instances', 'action' => 'exportCsv'],
        ['pass' => ['instance_namespace']]
    );



    # Categories Controller
    # -------------------------------------------------------------------------
    # add: 
    $routes->connect(
        '/:instance_namespace/admin/categories/add',
        ['controller' => 'Categories', 'action' => 'add'],
        ['pass' => ['instance_namespace']]
    );

    # edit
    $routes->connect(
        '/:instance_namespace/admin/categories/:id/edit',
        ['controller' => 'Categories', 'action' => 'edit'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );

    # delete
    $routes->connect(
        '/:instance_namespace/admin/categories/:id/delete',
        ['controller' => 'Categories', 'action' => 'delete'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );


    # OrganizationTypes Controller
    # -------------------------------------------------------------------------
    # add: 
    $routes->connect(
        '/:instance_namespace/admin/organization_types/add',
        ['controller' => 'OrganizationTypes', 'action' => 'add'],
        ['pass' => ['instance_namespace']]
    );

    # edit
    $routes->connect(
        '/:instance_namespace/admin/organization_types/:id/edit',
        ['controller' => 'OrganizationTypes', 'action' => 'edit'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );

    # delete
    $routes->connect(
        '/:instance_namespace/admin/organization_types/:id/delete',
        ['controller' => 'OrganizationTypes', 'action' => 'delete'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );



    # =================================================================================
    # instance interaction
    # =================================================================================

    # instance mapping
    $routes->connect(
        '/:instance_namespace',
        ['controller' => 'Instances', 'action' => 'preview'],
        ['pass' => ['instance_namespace']]
    );

    # map
    $routes->connect(
        '/:instance_namespace/map',
        ['controller' => 'Instances', 'action' => 'map'],
        ['pass' => ['instance_namespace']]
    );

    # dots
    $routes->connect(
        '/:instance_namespace/dots',
        ['controller' => 'Instances', 'action' => 'dots'],
        ['pass' => ['instance_namespace']]
    );



    # =================================================================================
    # projects interaction
    # =================================================================================

    # index
    $routes->connect(
        '/:instance_namespace/projects',
        ['controller' => 'Projects', 'action' => 'index'],
        ['pass' => ['instance_namespace']]
    );

    # csv export
    $routes->connect(
        '/:instance_namespace/projects/download',
        ['controller' => 'Projects', 'action' => 'exportCsv'],
        ['pass' => ['instance_namespace']]
    );


    # add
    $routes->connect(
        '/:instance_namespace/projects/add',
        ['controller' => 'Projects', 'action' => 'add'],
        ['pass' => ['instance_namespace']]
    );

    # view
    $routes->connect(
        '/:instance_namespace/projects/:id',
        ['controller' => 'Projects', 'action' => 'view'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );

    # edit
    $routes->connect(
        '/:instance_namespace/projects/:id/edit',
        ['controller' => 'Projects', 'action' => 'edit'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );

    # delete
    $routes->connect(
        '/:instance_namespace/projects/:id/delete',
        ['controller' => 'Projects', 'action' => 'delete'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );


    // $routes->fallbacks('DashedRoute');
});

// OJO!: es muy importante definir esta url al FINAL!, pues así, todas las
// llamadas internas a ['controller' => 'Instances', 'action' => 'home'] caerán
// sobre la versión que considera el lenguaje.
//
// de lo contrario, éstas serán transformadas a algo como: http://<host>/?lang=en
// lo que desactiva el uso del lenguaje.
Router::scope("/", function ($routes) {
    $routes->connect('/', ['controller' => 'Instances', 'action' => 'home']);
});

Plugin::routes();
