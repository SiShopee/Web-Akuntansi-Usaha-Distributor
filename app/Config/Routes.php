<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rute untuk pengecekan database
$routes->get('CekDatabase', 'CekDatabase::index');

// Rute Login
$routes->get('login', 'Auth::index');
$routes->post('auth/process_login', 'Auth::process_login');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('reset-admin', 'Auth::reset_admin');

// Rute Registrasi
$routes->get('register', 'Auth::register');
$routes->post('auth/process_register', 'Auth::process_register');
$routes->get('fix-password', 'Auth::fix_password');

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
$routes->get('karyawan/delete/(:num)', 'Karyawan::delete/$1');

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