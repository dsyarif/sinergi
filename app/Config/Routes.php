<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');

// opd
$routes->group('rpjpd', static function ($routes) {
  $routes->add('/', 'Rpjpd\PerRpjpd');
  $routes->add('list-data', 'Rpjpd\PerRpjpd::listAjax');
  $routes->add('save', 'Rpjpd\PerRpjpd::save');
  $routes->add('update', 'Rpjpd\PerRpjpd::update');
  $routes->add('edit/(:num)', 'Rpjpd\PerRpjpd::edit/$1');
  $routes->add('delete/(:num)', 'Rpjpd\PerRpjpd::delete/$1');
});
