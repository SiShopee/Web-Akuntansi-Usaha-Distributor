<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rute untuk pengecekan database
$routes->get('CekDatabase', 'CekDatabase::index');

// --- Rute Login (PERBAIKAN) ---
$routes->get('login', 'Auth::index');

// PENTING: Arahkan 'login/auth' ke 'Auth::process_login'
// Karena Controller kamu namanya Auth.php, bukan Login.php
$routes->post('login/auth', 'Auth::process_login'); 
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');

// --- Rute Registrasi (PERBAIKAN) ---
$routes->get('register', 'Auth::register');

// PENTING: Arahkan 'register/store' ke 'Auth::process_register'
$routes->post('register/store', 'Auth::process_register');

// Rute Manajemen Produk
$routes->get('produk', 'Produk::index');          // Tampilkan tabel
$routes->get('produk/create', 'Produk::create');  // Tampilkan form tambah
$routes->post('produk/store', 'Produk::store');   // Proses simpan data
$routes->get('produk/delete/(:num)', 'Produk::delete/$1'); // Hapus data

// Rute Kasir
$routes->get('transaksi', 'Transaksi::index');
$routes->post('transaksi/add', 'Transaksi::add_to_cart');
$routes->get('transaksi/clear', 'Transaksi::clear_cart');
$routes->post('transaksi/process_payment', 'Transaksi::process_payment');

// Rute Manajemen Karyawan
$routes->get('karyawan', 'Karyawan::index');
$routes->get('karyawan/create', 'Karyawan::create');
$routes->post('karyawan/store', 'Karyawan::store');
$routes->get('karyawan/edit/(:num)', 'Karyawan::edit/$1');    // URL untuk buka form edit
$routes->post('karyawan/update/(:num)', 'Karyawan::update/$1'); // URL untuk simpan edit
$routes->get('karyawan/delete/(:num)', 'Karyawan::delete/$1');  // URL untuk hapus

// Rute Absensi
$routes->get('absensi', 'Absensi::index');
$routes->get('absensi/create', 'Absensi::create');
$routes->post('absensi/store', 'Absensi::store');

// Rute Penggajian
$routes->get('gaji', 'Gaji::index');
$routes->get('gaji/create', 'Gaji::create');
$routes->post('gaji/process', 'Gaji::process');

$routes->get('laporan', 'Laporan::index');

$routes->get('produk/restock/(:num)', 'Produk::restock/$1');
$routes->post('produk/process_restock', 'Produk::process_restock');

// Rute Riwayat Stok
$routes->get('riwayat', 'Riwayat::index');

$routes->get('profil', 'Profil::index');
$routes->post('profil/update', 'Profil::update');