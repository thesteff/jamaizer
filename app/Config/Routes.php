<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->add('member/inscription', 'Member::create');
$routes->add('member/update', 'Member::update');
$routes->add('member/connexion', 'Member::login');
$routes->add('member/deconnexion', 'Member::logout');
$routes->add('member/profil', 'Member::view');

// TODO à modifier : on doit accéder à une page différente par groupe, via un argument dans l'url
$routes->add('group/create', 'Group::create');
$routes->add('group/view/(:segment)', 'Group::view/$1');
$routes->add('group', 'Group::index');

$routes->add('admin/group/(:segment)', 'admin::acceptGroup/$1');
$routes->add('admin', 'Admin::index');

$routes->match(['get', 'post'], 'news/create', 'News::create');
$routes->add('news/(:segment)', 'News::view/$1');
$routes->add('news', 'News::index');

$routes->add('(:any)', 'Pages::view/$1');
$routes->get('/', 'Home::index');
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
