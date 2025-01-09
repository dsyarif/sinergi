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


// Program Renstra
$routes->group('program-renstra', static function ($routes) {
  $routes->add('/', 'Renstra\TujuanRenstra');
  $routes->add('add/(:any)', 'Renstra\ProgramRenstra::add/$1');
  $routes->add('add-indi', 'Renstra\ProgramRenstra::add_indi');
  $routes->add('update-indi', 'Renstra\ProgramRenstra::update_indi');
  $routes->add('delete-indi/(:num)', 'Renstra\ProgramRenstra::delete_indi/$1');

  $routes->add('set-rpjmd/(:num)', 'Renstra\ProgramRenstra::set_rpjmd/$1');

  $routes->add('choose-kegiatan', 'Renstra\ProgramRenstra::choose_kegiatan');
  $routes->add('edit-choose-kegiatan', 'Renstra\ProgramRenstra::edit_choose_kegiatan');
  $routes->add('delete-ip-keg/(:num)/(:any)', 'Renstra\ProgramRenstra::delete_ip_keg/$1/$2');
});

// Kegiatan Renstra
$routes->group('kegiatan-renstra', static function ($routes) {
  $routes->add('/', 'Renstra\TujuanRenstra');
  $routes->add('add/(:any)', 'Renstra\KegiatanRenstra::add/$1');
  $routes->add('add-indi', 'Renstra\KegiatanRenstra::add_indi');
  $routes->add('update-indi', 'Renstra\KegiatanRenstra::update_indi');
  $routes->add('delete-indi/(:num)', 'Renstra\KegiatanRenstra::delete_indi/$1');

  $routes->add('set-rpjmd/(:num)', 'Renstra\KegiatanRenstra::set_rpjmd/$1');

  $routes->add('choose-subkegiatan', 'Renstra\KegiatanRenstra::choose_subkegiatan');
  $routes->add('edit-choose-subkegiatan', 'Renstra\KegiatanRenstra::edit_choose_subkegiatan');
  $routes->add('delete-ik-subkeg/(:num)/(:any)', 'Renstra\KegiatanRenstra::delete_ik_subkeg/$1/$2');
});
