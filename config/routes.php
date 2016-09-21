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
    # STATIC PAGES
    # =================================================================================
    
    # home
    $routes->connect('/', ['controller' => 'Instances', 'action' => 'home']);


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

    # graph
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


    # =================================================================================
    # users interaction
    # =================================================================================

    # login
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    
    # logout
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    
    # add
    $routes->connect('/sign-up', ['controller' => 'Users', 'action' => 'add']);
    
    # view
    $routes->connect('/users/:id', ['controller' => 'Users', 'action' => 'view'],
        [
            'pass' => ['id'],
            'id'   => '[0-9]+'
        ]
    );
    $routes->connect('/:instance_namespace/users/:id', ['controller' => 'Users', 'action' => 'view'],
        [
            'pass' => ['id', 'instance_namespace'],
            'id'   => '[0-9]+'
        ]
    );
    
    # edit
    $routes->connect(
        '/users/:id/edit',
        ['controller' => 'Users', 'action' => 'edit'],
        [
            'pass' => ['id'],
            'id'   => '[0-9]+'
        ]
    );

    # delete
    $routes->connect(
        '/users/:id/delete',
        ['controller' => 'Users', 'action' => 'delete'],
        [
            'pass' => ['id'],
            'id'   => '[0-9]+'
        ]
    );


    # --------------------
    ### COMPLETE LIST
    ###

    ## Instances:
    # (OK) index   (sysadmin)
    # (OK) add     (sysadmin)
    # (OK) delete  (sysadmin)
    # (OK) view    (admin)
    # (OK) edit    (admin)
    # (OK) preview (all)
    # (OK) map     (all)
    # (NO) dots    (all)
    
    ## Categories
    # (OK) index   (no) -- implemented on Instances view
    # (OK) add     (admin)
    # (OK) view    (no) -- implemented on Instances view
    # (OK) edit    (admin)
    # (OK) delete  (admin)

    ## OrganizationTypes
    # (OK) index   (no) -- implemented on Instances view
    # (OK) add     (admin)
    # (OK) view    (no) -- implemented on Instances view
    # (OK) edit    (admin)
    # (OK) delete  (admin)

    ## Projects
    # (OK) index   (all)
    # (OK) add     (logged user)
    # (OK) view    (all)
    # (OK) edit    (owner user)
    # (OK) delete  (owner user)
   
    ## Users
    # index   (no) -- implemented on Instances view
    # (OK) view    (all)
    # (OK) add     (all)
    # edit    (user)
    # (OK) delete  (user)

    ## Continents, Subcontinents, Countries, Cities, Roles
    # (OK) index   (no)
    # (OK) add     (no)
    # (OK) view    (no)
    # (OK) edit    (no)
    # (OK) delete  (no)

        

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
