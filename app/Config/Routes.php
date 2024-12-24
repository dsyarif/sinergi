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

// Tahapan
$routes->group('tahapan', static function ($routes) {
  $routes->add('/', 'Tahapan');
  $routes->add('save', 'Tahapan::save');
  $routes->add('update', 'Tahapan::update');
  $routes->add('delete/(:num)', 'Tahapan::delete/$1');
});

// Resntra
$routes->group('renstra', static function ($routes) {
  $routes->add('/', 'Renstra\Renstra');
  $routes->add('set-rpjmd/(:num)', 'Renstra\Renstra::set_rpjmd/$1');
});

// Tujuan Renstra
$routes->group('tujuan-renstra', static function ($routes) {
  $routes->add('/', 'Renstra\TujuanRenstra');
  $routes->add('add/(:any)', 'Renstra\TujuanRenstra::add/$1');
  $routes->add('save', 'Renstra\TujuanRenstra::save');
  $routes->add('update', 'Renstra\TujuanRenstra::update');
  $routes->add('delete/(:num)', 'Renstra\TujuanRenstra::delete/$1');

  $routes->add('add-indi', 'Renstra\TujuanRenstra::add_indi');
  $routes->add('update-indi', 'Renstra\TujuanRenstra::update_indi');
  $routes->add('delete-indi/(:num)', 'Renstra\TujuanRenstra::delete_indi/$1');

  $routes->add('set-rpjmd/(:num)', 'Renstra\TujuanRenstra::set_rpjmd/$1');
});

// Sasaran Renstra
$routes->group('sasaran-renstra', static function ($routes) {
  $routes->add('/', 'Renstra\SasaranRenstra');
  $routes->add('add/(:any)', 'Renstra\SasaranRenstra::add/$1');
  $routes->add('save', 'Renstra\SasaranRenstra::save');
  $routes->add('update', 'Renstra\SasaranRenstra::update');
  $routes->add('delete/(:num)', 'Renstra\SasaranRenstra::delete/$1');

  $routes->add('add-indi', 'Renstra\SasaranRenstra::add_indi');
  $routes->add('update-indi', 'Renstra\SasaranRenstra::update_indi');
  $routes->add('delete-indi/(:num)', 'Renstra\SasaranRenstra::delete_indi/$1');

  $routes->add('set-rpjmd/(:num)', 'Renstra\SasaranRenstra::set_rpjmd/$1');

  $routes->add('choose-program', 'Renstra\SasaranRenstra::choose_program');
  $routes->add('edit-choose-program', 'Renstra\SasaranRenstra::edit_choose_program');
  $routes->add('delete-is-prog/(:num)/(:any)', 'Renstra\SasaranRenstra::delete_is_prog/$1/$2');
});

// Indikator Tujuan Renstra
$routes->group('indi-tujuan-renstra', static function ($routes) {
  $routes->add('/(:any)', 'Renstra\IndiTujuanRenstra::index/$1');
  $routes->add('add/(:any)', 'Renstra\IndiTujuanRenstra::add/$1');
  $routes->add('save', 'Renstra\IndiTujuanRenstra::save');
  $routes->add('update', 'Renstra\IndiTujuanRenstra::update');
  $routes->add('delete/(:num)', 'Renstra\IndiTujuanRenstra::delete/$1');
});

// Program Renstra
$routes->group('program-renstra', static function ($routes) {
  $routes->add('/', 'Renstra\TujuanRenstra');
  $routes->add('add/(:any)', 'Renstra\ProgramRenstra::add/$1');
});
