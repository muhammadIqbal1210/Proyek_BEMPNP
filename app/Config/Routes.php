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
$routes->get('pengumuman', 'Home::pengumuman');
$routes->get('pengumuman/detail/(:num)', 'Home::detailpengumuman/$1');
$routes->get('layanan', 'Home::layanan');
$routes->get('profil', 'Home::profil');
$routes->get('struktur', 'Home::struktur');
$routes->get('kontak', 'Home::kontak');
$routes->get('layanan/advokasi', 'Home::advokasi');
$routes->post('layanan/kirim_lapor', 'Home::kirim_lapor');
$routes->get('katalog', 'Home::katalog');
$routes->get('beasiswa', 'Home::beasiswa');
$routes->get('beasiswa/detail/(:num)', 'Home::detailbeasiswa/$1');
$routes->get('lomba', 'Home::lomba');
$routes->get('lomba/detail/(:num)', 'Home::detaillomba/$1');
$routes->get('event', 'Home::event');
$routes->get('event/detail/(:num)', 'Home::detailevent/$1');
$routes->get('berita', 'Home::berita');
$routes->get('berita/detail/(:any)', 'Home::detailberita/$1');

$routes->group('member', ['filter' => 'member', 'namespace' => 'App\Controllers\Member'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    // Routes Profile
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
    $routes->get('kanban', 'KanbanController::kanban');
    $routes->post('kanban/board/store', 'KanbanController::storeBoard');
    $routes->post('kanban/board/update/(:num)', 'KanbanController::updateBoard/$1');
    $routes->post('kanban/task/store', 'KanbanController::storeTask');
    $routes->post('kanban/task/status', 'KanbanController::updateTaskStatus');
    $routes->post('kanban/task/delete/(:num)', 'KanbanController::deleteTask/$1');
    // Routes Beasiswa Member
    $routes->get('beasiswa', 'Beasiswa::index');
    $routes->get('beasiswa/create', 'Beasiswa::create');
    $routes->post('beasiswa/store', 'Beasiswa::store');
    $routes->get('beasiswa/edit/(:num)', 'Beasiswa::edit/$1');
    $routes->post('beasiswa/update/(:num)', 'Beasiswa::update/$1');
    $routes->get('beasiswa/delete/(:num)', 'Beasiswa::delete/$1');
    // Routes Lomba Member
    $routes->get('lomba', 'Lomba::index');
    $routes->get('lomba/create', 'Lomba::create');
    $routes->post('lomba/store', 'Lomba::store');
    $routes->get('lomba/edit/(:num)', 'Lomba::edit/$1');
    $routes->post('lomba/update/(:num)', 'Lomba::update/$1');
    $routes->get('lomba/delete/(:num)', 'Lomba::delete/$1');
    // Routes Event Member
    $routes->get('event', 'Event::index');
    $routes->get('event/create', 'Event::create');
    $routes->post('event/store', 'Event::store');
    $routes->get('event/edit/(:num)', 'Event::edit/$1');
    $routes->post('event/update/(:num)', 'Event::update/$1');
    $routes->get('event/delete/(:num)', 'Event::delete/$1');
    // Routes Berita Member
    $routes->get('berita', 'Berita::index');
    $routes->get('berita/create', 'Berita::create');
    $routes->post('berita/store', 'Berita::store');
    $routes->get('berita/edit/(:num)', 'Berita::edit/$1');
    $routes->post('berita/update/(:num)', 'Berita::update/$1');
    $routes->get('berita/delete/(:num)', 'Berita::delete/$1');
    // Routes Katalog Member
    $routes->get('katalog', 'Katalog::index');
    $routes->get('katalog/create', 'Katalog::create');
    $routes->post('katalog/store', 'Katalog::store');
    $routes->get('katalog/edit/(:num)', 'Katalog::edit/$1');
    $routes->post('katalog/update/(:num)', 'Katalog::update/$1');
    $routes->get('katalog/delete/(:num)', 'Katalog::delete/$1');
});
$routes->group('admin', ['filter' => 'admin','namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
    //User route
    $routes->get('user', 'UserController::index');
    $routes->post('user/store', 'UserController::store');
    $routes->get('user/edit/(:num)', 'UserController::edit/$1'); // Mengambil data user spesifik (untuk JS)
    $routes->put('user/update/(:num)', 'UserController::update/$1'); // Mengupdate data user (UPDATE)
    $routes->get('user/delete/(:num)', 'UserController::delete/$1'); // Menghapus user (DELETE)
    // Profile User
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
    // <!--Route Pengumuman-->
    $routes->get('pengumuman', 'Pengumuman::index'); // URL: /admin/pengumuman/index
    $routes->get('pengumuman/index', 'Pengumuman::index');
    $routes->get('pengumuman/create', 'Pengumuman::create');
    $routes->post('pengumuman/store', 'Pengumuman::store');
    $routes->get('pengumuman/edit/(:num)', 'Pengumuman::edit/$1'); // Ambil data JSON
    $routes->post('pengumuman/update/(:num)', 'Pengumuman::update/$1'); // Proses Update
    $routes->get('pengumuman/delete/(:num)', 'Pengumuman::delete/$1');
    //Route Beasiswa
    $routes->get('beasiswa', 'Beasiswa::index'); 
    $routes->get('beasiswa/index', 'Beasiswa::index');
    $routes->get('beasiswa/pengajuan', 'Beasiswa::pengajuan');
    $routes->get('beasiswa/approve/(:num)', 'Beasiswa::approve/$1');
    $routes->get('beasiswa/reject/(:num)', 'Beasiswa::reject/$1');
    $routes->post('beasiswa/store', 'Beasiswa::store');
    $routes->get('beasiswa/edit/(:num)', 'Beasiswa::edit/$1'); // Ambil data JSON
    $routes->post('beasiswa/update/(:num)', 'Beasiswa::update/$1'); // Proses Update
    $routes->get('beasiswa/delete/(:num)', 'Beasiswa::delete/$1');
    // Routes Lomba
    $routes->get('lomba', 'Lomba::index'); 
    $routes->get('lomba/index', 'Lomba::index');
    $routes->get('lomba/pengajuan', 'Lomba::pengajuan');
    $routes->get('lomba/approve/(:num)', 'Lomba::approve/$1');
    $routes->get('lomba/reject/(:num)', 'Lomba::reject/$1');
    $routes->post('lomba/store', 'Lomba::store');
    $routes->get('lomba/edit/(:num)', 'lomba::edit/$1'); // Ambil data JSON
    $routes->post('lomba/update/(:num)', 'lomba::update/$1'); // Proses Update
    $routes->get('lomba/delete/(:num)', 'lomba::delete/$1');
    //Event Route
    $routes->get('event', 'Event::index'); 
    $routes->get('event/index', 'Event::index');
    $routes->get('event/pengajuan', 'Event::pengajuan');
    $routes->get('event/approve/(:num)', 'Event::approve/$1');
    $routes->get('event/reject/(:num)', 'Event::reject/$1');
    $routes->post('event/store', 'Event::store');
    $routes->get('event/edit/(:num)', 'event::edit/$1'); // Ambil data JSON
    $routes->post('event/update/(:num)', 'event::update/$1'); // Proses Update
    $routes->get('event/delete/(:num)', 'event::delete/$1');
    //Route Berita
    $routes->get('berita', 'Berita::index'); 
    $routes->get('berita/index', 'Berita::index');
    $routes->get('berita/pengajuan', 'Berita::pengajuan');
    $routes->get('berita/approve/(:num)', 'Berita::approve/$1');
    $routes->get('berita/reject/(:num)', 'Berita::reject/$1');
    $routes->post('berita/store', 'Berita::store');
    $routes->get('berita/edit/(:num)', 'berita::edit/$1'); // Ambil data JSON
    $routes->post('berita/update/(:num)', 'berita::update/$1'); // Proses Update
    $routes->get('berita/delete/(:num)', 'berita::delete/$1');
    // Route Katalog
    $routes->get('katalog', 'Katalog::index');
    $routes->get('katalog/index', 'Katalog::index');
    $routes->get('katalog/pengajuan', 'Katalog::pengajuan');
    $routes->get('katalog/approve/(:num)', 'Katalog::approve/$1');
    $routes->get('katalog/reject/(:num)', 'Katalog::reject/$1');
    $routes->post('katalog/store', 'Katalog::store');
    $routes->get('katalog/edit/(:num)', 'katalog::edit/$1');
    $routes->post('katalog/update/(:num)', 'katalog::update/$1');
    $routes->get('katalog/delete/(:num)', 'katalog::delete/$1');
    // Route Kanban
    $routes->get('kanban', 'KanbanController::kanban');
    $routes->post('kanban/board/store', 'KanbanController::storeBoard');
    $routes->post('kanban/board/update/(:num)', 'KanbanController::updateBoard/$1');
    $routes->post('kanban/task/store', 'KanbanController::storeTask');
    $routes->post('kanban/task/status', 'KanbanController::updateTaskStatus');
    $routes->post('kanban/task/delete/(:num)', 'KanbanController::deleteTask/$1');
    //Route Laporan
    $routes->get('laporan', 'Laporan::index');
    $routes->get('laporan/index', 'Laporan::index');
    $routes->post('laporan/update_status/(:num)', 'Laporan::update_status/$1');
    $routes->get('laporan/delete/(:num)', 'Laporan::delete/$1');
    // Route Pengurus
    $routes->get('pengurus', 'Pengurus::index');
    $routes->post('pengurus/store', 'Pengurus::store');
    $routes->get('pengurus/edit/(:num)', 'Pengurus::edit/$1'); // Ambil data JSON
    $routes->post('pengurus/update/(:num)', 'Pengurus::update/$1'); // Proses Update
    $routes->get('pengurus/delete/(:num)', 'Pengurus::delete/$1');
    // Route Profil Organisasi
    $routes->get('profil', 'Profilorganisasi::index');
    $routes->post('profil/store', 'Profilorganisasi::store');
    $routes->get('profil/edit/(:num)', 'Profilorganisasi::edit/$1');
    $routes->post('profil/update/(:num)', 'Profilorganisasi::update/$1');
    $routes->get('profil/delete/(:num)', 'Profilorganisasi::delete/$1');
    // Route Kontak
    $routes->get('kontak', 'Kontak::index');
    $routes->post('kontak/store', 'Kontak::store');
    $routes->get('kontak/edit/(:num)', 'Kontak::edit/$1');
    $routes->post('kontak/update/(:num)', 'Kontak::update/$1');
    $routes->get('kontak/delete/(:num)', 'Kontak::delete/$1');
    });

