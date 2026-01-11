<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');

// Rute untuk pengecekan database
$routes->get('CekDatabase', 'CekDatabase::index');

// --- Rute Login ---
$routes->get('login', 'Auth::index');
$routes->post('login/auth', 'Auth::process_login');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');

// --- Rute Registrasi ---
$routes->get('register', 'Auth::register');
$routes->post('register/store', 'Auth::process_register');

// --- Rute Manajemen Produk (DATA BARANG) ---
$routes->get('produk', 'Produk::index');          // Tampilkan tabel
$routes->get('produk/create', 'Produk::create');  // Tampilkan form tambah
$routes->post('produk/store', 'Produk::store');   // Proses simpan data baru
$routes->get('produk/delete/(:num)', 'Produk::delete/$1'); // Hapus data

// [BARU] Rute untuk Edit Barang (Tombol Kuning)
$routes->post('produk/update/(:num)', 'Produk::update/$1');

// --- Rute Riwayat Stok (STOK GUDANG) ---
$routes->get('riwayat', 'Riwayat::index');

// [BARU] Rute untuk Tambah Stok via Modal (Tombol Hijau)
$routes->post('riwayat/add_stok', 'Riwayat::add_stok');

// --- Rute Kasir ---
$routes->get('transaksi', 'Transaksi::index');
$routes->post('transaksi/add', 'Transaksi::add_to_cart');
$routes->get('transaksi/clear', 'Transaksi::clear_cart');
$routes->post('transaksi/process_payment', 'Transaksi::process_payment');

// --- Rute Manajemen Karyawan ---
$routes->get('karyawan', 'Karyawan::index');
$routes->get('karyawan/create', 'Karyawan::create');
$routes->post('karyawan/store', 'Karyawan::store');
$routes->get('karyawan/edit/(:num)', 'Karyawan::edit/$1');
$routes->post('karyawan/update/(:num)', 'Karyawan::update/$1');
$routes->get('karyawan/delete/(:num)', 'Karyawan::delete/$1');

// --- Rute Absensi ---
$routes->get('absensi', 'Absensi::index');
$routes->get('absensi/create', 'Absensi::create');
$routes->post('absensi/store', 'Absensi::store');

// --- Rute Penggajian ---
$routes->get('gaji', 'Gaji::index');
$routes->get('gaji/create', 'Gaji::create');
$routes->post('gaji/process', 'Gaji::process');

// --- Rute Laporan ---
$routes->get('laporan', 'Laporan::index');

// --- Rute Lainnya ---
$routes->get('profil', 'Profil::index');
$routes->post('profil/update', 'Profil::update');

$routes->post('pesan/kirim', 'Pesan::kirim');
$routes->get('pesan/baca/(:num)', 'Pesan::baca/$1');

// Rute Absen Dashboard
$routes->post('dashboard/absen', 'Dashboard::absen_masuk');
