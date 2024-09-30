<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');

// Periode RPJPD
$routes->group('rpjpd', static function ($routes) {
  $routes->add('/', 'Rpjpd\PerRpjpd');
  $routes->add('list-data', 'Rpjpd\PerRpjpd::listAjax');
  $routes->add('save', 'Rpjpd\PerRpjpd::save');
  $routes->add('update', 'Rpjpd\PerRpjpd::update');
  $routes->add('edit/(:num)', 'Rpjpd\PerRpjpd::edit/$1');
  $routes->add('delete/(:num)', 'Rpjpd\PerRpjpd::delete/$1');
});

// Periode RPJMD
$routes->group('rpjmd', static function ($routes) {
  $routes->add('/', 'Rpjmd\PeriodeRpjmd');
  $routes->add('list-data', 'Rpjmd\PeriodeRpjmd::listAjax');
  $routes->add('save', 'Rpjmd\PeriodeRpjmd::save');
  $routes->add('update', 'Rpjmd\PeriodeRpjmd::update');
  $routes->add('edit/(:num)', 'Rpjmd\PeriodeRpjmd::edit/$1');
  $routes->add('delete/(:num)', 'Rpjmd\PeriodeRpjmd::delete/$1');
});

// OPD
$routes->group('opd', static function ($routes) {
  $routes->add('/', 'Opd');
});

// Resntra
$routes->group('renstra', static function ($routes) {
  $routes->add('/', 'Renstra\Renstra');
});

// Tujuan Renstra
$routes->group('tujuan-renstra', static function ($routes) {
  $routes->add('/', 'Renstra\TujuanRenstra');
  $routes->add('add/(:any)', 'Renstra\TujuanRenstra::add/$1');
  $routes->add('save', 'Renstra\TujuanRenstra::save');
  $routes->add('update', 'Renstra\TujuanRenstra::update');
  $routes->add('delete/(:num)', 'Renstra\TujuanRenstra::delete/$1');
});

// Indikator Tujuan Renstra
$routes->group('indi-tujuan-renstra', static function ($routes) {
  $routes->add('/(:any)', 'Renstra\IndiTujuanRenstra::index/$1');
  $routes->add('add/(:any)', 'Renstra\IndiTujuanRenstra::add/$1');
  $routes->add('save', 'Renstra\IndiTujuanRenstra::save');
  $routes->add('update', 'Renstra\IndiTujuanRenstra::update');
  $routes->add('delete/(:num)', 'Renstra\IndiTujuanRenstra::delete/$1');
});
