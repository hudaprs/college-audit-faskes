<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */


// ========== Dashboard Section
$routes->get('/', 'DashboardController::index');
// ========== End Dashboard Section


// ========== Tests Section
$routes->group('tests', function ($routes) {
    $routes->get('mapping-facility', 'TestController::mappingFacility');
    $routes->get('mapping-health-facility-auditor', 'TestController::mappingHealthFacilityAuditor');
    $routes->get('question', 'TestController::question');
    $routes->get('mapping-question', 'TestController::mappingQuestion');
});
// ========== End Tests Section

// ========== Route Section
$routes->group('auth', function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login-action', 'AuthController::loginAction');
    $routes->get('logout', 'AuthController::logout');
});
// ========== End Route Section


// ========== Master
$routes->group('master', function ($routes) {
    // User
    $routes->group(
        'users',
        function ($routes) {
            $routes->get('/', 'UserController::index');
            $routes->get('create', 'UserController::create');
            $routes->post('store', 'UserController::store');
            $routes->get('(:segment)', 'UserController::show/$1');
            $routes->get('(:segment)/edit', 'UserController::edit/$1');
            $routes->post('(:segment)/update', 'UserController::update/$1');
            $routes->get('(:segment)/delete', 'UserController::delete/$1');
        }
    );

    $routes->group(
        'facilitie',
        function ($routes) {
            $routes->get('/', 'FacilitieController::index');
            $routes->get('create', 'FacilitieController::create');
            $routes->post('store', 'FacilitieController::store');
            $routes->get('(:segment)', 'FacilitieController::show/$1');
            $routes->get('(:segment)/edit', 'FacilitieController::edit/$1');
            $routes->post('(:segment)/update', 'FacilitieController::update/$1');
            $routes->get('(:segment)/delete', 'FacilitieController::delete/$1');
        }
    );


});
// ========== End Master

// ========== Facility Management
$routes->group('facility-management', function ($routes) {
    // Health Facility
    $routes->group(
        'health-facility',
        function ($routes) {
            $routes->get('/', 'HealthFacilityController::index');
            $routes->get('create', 'HealthFacilityController::create');
            $routes->post('store', 'HealthFacilityController::store');
            $routes->get('(:segment)', 'HealthFacilityController::show/$1');
            $routes->get('(:segment)/edit', 'HealthFacilityController::edit/$1');
            $routes->post('(:segment)/update', 'HealthFacilityController::update/$1');
            $routes->get('(:segment)/delete', 'HealthFacilityController::delete/$1');
        }
    );

    // Mapping Auditor
    $routes->group(
        'mapping-auditor',
        function ($routes) {
            $routes->get('/', 'MappingAuditorController::index');
            $routes->get('(:segment)/edit', 'MappingAuditorController::edit/$1');
            $routes->post('(:segment)/update', 'MappingAuditorController::update/$1');
        }
    );
});
// ========== End Facility Management

// ========== Question Management
$routes->group('question-management', function ($routes) {
    // Mapping Question
    $routes->group(
        'mapping-question',
        function ($routes) {
            $routes->get('/', 'MappingQuestionController::index');
            $routes->get('(:segment)/edit', 'MappingQuestionController::edit/$1');
            $routes->post('(:segment)/update', 'MappingQuestionController::update/$1');
        }
    );
});
// ========== End Question Management

// ========== Audit Question Management
$routes->group('question-management', function ($routes) {
    // Audit Criterias
    $routes->group(
        'audit-criterias',
        function ($routes) {
            $routes->get('/', 'AuditCriteriasController::index');
            $routes->get('create', 'AuditCriteriasController::create');
            $routes->post('store', 'AuditCriteriasController::store');
            $routes->get('(:segment)', 'AuditCriteriasController::show/$1');
            $routes->get('(:segment)/edit', 'AuditCriteriasController::edit/$1');
            $routes->post('(:segment)/update', 'AuditCriteriasController::update/$1');
            $routes->get('(:segment)/delete', 'AuditCriteriasController::delete/$1');
        }
    );
});
// ========== End Question Management


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}