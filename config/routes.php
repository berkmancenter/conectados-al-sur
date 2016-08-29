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

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('DashedRoute');

Router::scope('/', function (RouteBuilder $routes) {
    
    # =================================================================================
    # TESTING
    # =================================================================================
    
    # meanwhile: root as instance index
    $routes->connect('/', ['controller' => 'Instances', 'action' => 'index']);

    # defaut as status page
    $routes->connect('/status', ['controller' => 'Pages', 'action' => 'display', 'home']);


    # =================================================================================
    # admin page
    # =================================================================================

    # Instances Controller
    # -------------------------------------------------------------------------

    # index
    $routes->connect('/admin', ['controller' => 'Instances', 'action' => 'index']);

    # add
    $routes->connect('/admin/add', ['controller' => 'Instances', 'action' => 'add']);

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


    # Projects Controller
    # -------------------------------------------------------------------------
    # index: 
    $routes->connect(
        '/:instance_namespace/admin/projects',
        ['controller' => 'Projects', 'action' => 'index'],
        ['pass' => ['instance_namespace']]
    );


    # Users Controller
    # -------------------------------------------------------------------------
    # index: 
    $routes->connect(
        '/:instance_namespace/admin/users',
        ['controller' => 'Users', 'action' => 'index'],
        ['pass' => ['instance_namespace']]
    );


    # Categories Controller
    # -------------------------------------------------------------------------
    # index: 
    $routes->connect(
        '/:instance_namespace/admin/categories',
        ['controller' => 'Categories', 'action' => 'index'],
        ['pass' => ['instance_namespace']]
    );


    # OrganizationTypes Controller
    # -------------------------------------------------------------------------
    # index: 
    $routes->connect(
        '/:instance_namespace/admin/organization_types',
        ['controller' => 'OrganizationTypes', 'action' => 'index'],
        ['pass' => ['instance_namespace']]
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

    # graph
    $routes->connect(
        '/:instance_namespace/dots',
        ['controller' => 'Instances', 'action' => 'dots'],
        ['pass' => ['instance_namespace']]
    );


    # projects interaction
    # -------------------------------------------------------------------------

    # add project
    $routes->connect(
        '/:instance_namespace/projects/add',
        ['controller' => 'Projects', 'action' => 'add'],
        ['pass' => ['instance_namespace']]
    );

    # view project
    $routes->connect(
        '/:instance_namespace/projects/:id',
        ['controller' => 'Projects', 'action' => 'view'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );

    # edit project
    $routes->connect(
        '/:instance_namespace/projects/:id/edit',
        ['controller' => 'Projects', 'action' => 'edit'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );

    # delete project
    $routes->connect(
        '/:instance_namespace/projects/:id/delete',
        ['controller' => 'Projects', 'action' => 'delete'],
        [
            'pass' => ['instance_namespace', 'id'],
            'id'   => '[0-9]+'
        ]
    );

    # TODO: 

    # TODO:
    # - probablemente graph, map, index y download puedan ser abstraídos al 
    # mismo controlador!, pero con distintas vistas
    #
    # - limitar acceso con urls originales, que no ocupan el mapeo que propongo
    # - bloquear acceso a vistas de Entidades Bloqueadas:
    #    - Continents
    #    - Subcontinents
    #    - Countries
    #    - Cities
    #    - CategoriesProjects
    #    - Genres
    #    - ProjectStages
    #    - Roles

    # projects: index  (sysadmin, y download)
    # projects: view   (user)
    # projects: delete (user)
    # projects: modify (user)
    
    # users: index   (sysadmin)
    # users: view    (user)
    # users: add     (user)
    # users: modify  (user)
    # users: delete  (user)

    # Categories: index   (sysadmin)
    # Categories: view    (sysadmin)
    # Categories: add     (sysadmin)
    # Categories: modify  (sysadmin)
    # Categories: delete  (sysadmin)

    # OrganizationTypes: index   (sysadmin)
    # OrganizationTypes: view    (sysadmin)
    # OrganizationTypes: add     (sysadmin)
    # OrganizationTypes: modify  (sysadmin)
    # OrganizationTypes: delete  (sysadmin)
    

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('DashedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
