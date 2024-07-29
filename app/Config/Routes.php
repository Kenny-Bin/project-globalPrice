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
$routes->setDefaultController('Login');
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

// We get a performance increase by specifying the default
// route since we don't have to scan directories.    $routes->post('reservationMng/_chgIsUse', 'Reservation::chgIsUse');

$routes->get('login', 'Login::index');
$routes->post('loginProc', 'Login::loginProc');
$routes->post('logout', 'Login::logout');

$routes->group('', ['filter' => 'authGuard'], function ($routes){

    // 글로벌 홈페이지 가격표
    $routes->get('brandRegularPriceMng', 'GlobalPrice::index');
    $routes->post('brandRegularPriceMng', 'GlobalPrice::index');
    $routes->post('brandRegularPriceMng/_index', 'GlobalPrice::postIndex');
    $routes->get('brandRegularPriceMng/register', 'GlobalPrice::register');
    $routes->post('brandRegularPriceMng/_register', 'GlobalPrice::postRegister');
    $routes->post('brandRegularPriceMng/registerProc', 'GlobalPrice::registerProc');
    $routes->get('brandRegularPriceMng/branchProc', 'GlobalPrice::branchProc');
    $routes->post('brandRegularPriceMng/branchProc', 'GlobalPrice::branchProc');
    $routes->get('brandRegularPriceMng/_getBranch', 'GlobalPrice::getBranch');
    $routes->post('brandRegularPriceMng/modifyProc', 'GlobalPrice::modifyProc');
    $routes->post('brandRegularPriceMng/deleteProc', 'GlobalPrice::deleteProc');
    $routes->post('brandRegularPriceMng/categorySortProc', 'GlobalPrice::categorySortProc');
    $routes->post('brandRegularPriceMng/applyCorpProc', 'GlobalPrice::applyCorpProc');
    $routes->post('brandRegularPriceMng/chgState', 'GlobalPrice::chgState');
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
