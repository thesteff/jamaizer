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

// MEMBRES
$routes->add('ajax_member/(:any)', 'Ajax_member::$1');
$routes->add('member/inscription', 'Member::create');
$routes->add('member/update', 'Member::update');
$routes->add('member/profil', 'Member::view');

/** LES GROUPES **/
/** toutes les pages concernant les groupes **/
$routes->group('group', function($routes){
	$routes->add('', 'Group::index');
	$routes->add('create', 'Group::create');

	/** toutes les pages concernant UN SEUL groupe **/
	$routes->group('(:segment)', function($routes){ //'segment' = slug du groupe
		$routes->add('', 'Group::view/$1');
		$routes->add('view', 'Group::view/$1');
		$routes->add('about', 'Group::about/$1');
		$routes->add('notification', 'Group::notification/$1');
//TODO modifier l'usage de cette route "accept", car elle ne génère pas de vue
		$routes->add('notification/accept', 'Group::acceptMemberInGroup');
		$routes->add('update', 'Group::update/$1');
		$routes->add('delete', 'Group::delete/$1');

		/** Toutes les pages concernant LES EVENTS propres à UN GROUPE **/
		$routes->group('event', function($routes){
			$routes->add('', 'Event::viewEvents/$1'); //ici on voit les events liés à un groupe
			$routes->add('create', 'Event::create/$1'); //ici on crée un event qui sera lié à un groupe

		});
	});
});

/** LES EVENTS **/
/** Toutes les pages concernant LES EVENTS **/
$routes->group('event', function($routes){
	$routes->add('', 'Event::viewEvents'); //ici on voit les events peu importe s'ils ont un lien avec un groupe
	$routes->add('create', 'Event::create'); //ici on crée un event qui n'est pas lié à un groupe
	
	/** toutes les pages qui concernent UN SEUL EVENT **/
	$routes->group('(:segment)', function($routes){ // segment = slug du groupe
		$routes->add('', 'Event::viewOneEvent/$1');
		$routes->add('update', 'Event::update/$1');
//TODO modifier l'usage de cette route "delete", car elle ne génère pas de vue
		$routes->add('delete', 'Event::delete/$1');
		$routes->add('members', 'Event::members/$1');
//TODO modifier l'usage de cette route "accept", car elle ne génère pas de vue
		$routes->add('members/accept/(:segment)', 'Event::acceptMemberInEvent/$1/$2');

		/** toutes les pages concernant les DATES dans UN EVENT **/
		$routes->group('date', function($routes){
			$routes->add('create', 'Date::create/$1/$2');
		});
	});
});


/** ADMIN **/
$routes->group('admin', function($routes){
	$routes->add('', 'Admin::index');
	$routes->add('group/(:segment)', 'admin::acceptGroup/$1');
});



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
