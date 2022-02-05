<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');



$routes->group("api", function($r) {
    $r->post("register", "UserController::register");
    $r->post("login", "UserController::login");
    $r->get("profile", "UserController::details", ['filter' => 'jwt-auth']);
    
    $r->resource('trainees', [ 'controller' => 'TraineeAPI']);
    $r->resource('trainers', [ 'controller' => 'TrainerAPI', 'filter' => 'jwt-auth']);
    $r->resource('regions', ['controller' => 'RegionAPI', 'filter' => 'jwt-auth']);
    $r->resource('provinces', ['controller' => 'ProvinceAPI', 'filter' => 'jwt-auth']);
    $r->resource('leagues', ['controller' => 'LeagueAPI', 'filter' => 'jwt-auth']);    
    $r->resource('personnes', ['controller' => 'PersonneAPI', 'filter' => 'jwt-auth']);    
    $r->resource('grades', ['controller' => 'GradeAPI', 'filter' => 'jwt-auth']);            
    $r->resource('typeentites', ['controller' => 'TypeEntiteApi', 'filter' => 'jwt-auth']);                
    $r->resource('typeactivites', ['controller' => 'TypeActiviteApi', 'filter' => 'jwt-auth']);                    
    $r->resource('activites', ['controller' => 'ActiviteApi', 'filter' => 'jwt-auth']); 
    $r->resource('entites', ['controller' => 'EntiteApi', 'filter' => 'jwt-auth']);                    
});

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
