<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Publik Route
$routes->get('/', 'Home::index');
$routes->get('login', 'Login::index');              // Menampilkan form login
$routes->post('login/auth', 'Login::loginAuth');
$routes->get('register', 'Register::index'); // Untuk menampilkan form
$routes->post('register', 'Register::store');
$routes->get('logout', 'Auth::logout');
//Akses Pengumuman 
$routes->get('pengumuman', 'Home::pengumuman');
$routes->get('pengumuman/detail/(:num)', 'Home::detail/$1');

$routes->group('member', ['filter' => 'member'], function($routes) {
    $routes->get('dashboard', 'Member\Dashboard::index');
});

$routes->group('admin', ['filter' => 'admin','namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    //User route
    $routes->get('user', 'UserController::index');
    $routes->post('user/store', 'UserController::store');
    $routes->get('user/edit/(:num)', 'UserController::edit/$1'); // Mengambil data user spesifik (untuk JS)
    $routes->put('user/update/(:num)', 'UserController::update/$1'); // Mengupdate data user (UPDATE)
    $routes->get('user/delete/(:num)', 'UserController::delete/$1'); // Menghapus user (DELETE)
    // <!--Route Pengumuman-->
    $routes->get('pengumuman', 'Pengumuman::index'); // URL: /admin/pengumuman/index
    $routes->get('pengumuman/index', 'Pengumuman::index');
    $routes->get('pengumuman/create', 'Pengumuman::create');
    $routes->post('pengumuman/store', 'Pengumuman::store');
    $routes->get('pengumuman/edit/(:num)', 'Pengumuman::edit/$1'); // Ambil data JSON
    $routes->post('pengumuman/update/(:num)', 'Pengumuman::update/$1'); // Proses Update
    $routes->get('pengumuman/delete/(:num)', 'Pengumuman::delete/$1');
    //Route Beasiswa
    $routes->get('beasiswa', 'Beasiswa::index'); // URL: /admin/pengumuman/index
    $routes->get('beasiswa/index', 'Beasiswa::index');
    $routes->post('beasiswa/store', 'Beasiswa::store');
    $routes->get('beasiswa/edit/(:num)', 'Beasiswa::edit/$1'); // Ambil data JSON
    $routes->post('beasiswa/update/(:num)', 'Beasiswa::update/$1'); // Proses Update
    $routes->get('beasiswa/delete/(:num)', 'Beasiswa::delete/$1');
    // Routes Lomba
    $routes->get('lomba', 'Lomba::index'); // URL: /admin/pengumuman/index
    $routes->get('lomba/index', 'Lomba::index');
    $routes->post('lomba/store', 'Lomba::store');
    $routes->get('lomba/edit/(:num)', 'lomba::edit/$1'); // Ambil data JSON
    $routes->post('lomba/update/(:num)', 'lomba::update/$1'); // Proses Update
    $routes->get('lomba/delete/(:num)', 'lomba::delete/$1');
    //Event Route
    $routes->get('event', 'Event::index'); // URL: /admin/pengumuman/index
    $routes->get('event/index', 'Event::index');
    $routes->post('event/store', 'Event::store');
    $routes->get('event/edit/(:num)', 'event::edit/$1'); // Ambil data JSON
    $routes->post('event/update/(:num)', 'event::update/$1'); // Proses Update
    $routes->get('event/delete/(:num)', 'event::delete/$1');
    //Route Berita
    $routes->get('berita', 'Berita::index'); // URL: /admin/pengumuman/index
    $routes->get('berita/index', 'Berita::index');
    $routes->post('berita/store', 'Berita::store');
    $routes->get('berita/edit/(:num)', 'berita::edit/$1'); // Ambil data JSON
    $routes->post('berita/update/(:num)', 'berita::update/$1'); // Proses Update
    $routes->get('event/delete/(:num)', 'berita::delete/$1');
    // Route Katalog
    $routes->get('katalog', 'Katalog::index'); // URL: /admin/pengumuman/index
    $routes->get('katalog/index', 'Katalog::index');
    $routes->post('katalog/store', 'Katalog::store');
    $routes->get('katalog/delete/(:num)', 'katalog::delete/$1');
    // ... routes admin lainnya
});
