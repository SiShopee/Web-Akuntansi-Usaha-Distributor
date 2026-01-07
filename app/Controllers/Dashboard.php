<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // 1. Cek Login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Panggil Koneksi Database Langsung
        $db = \Config\Database::connect();

        // Cek nama kolom quantity (jaga-jaga qty atau quantity)
        if ($db->fieldExists('quantity', 'sale_items')) {
            $kolomQty = 'quantity';
        } else {
            $kolomQty = 'qty';
        }

        // --- A. HITUNG OMZET (Metode Baru: Scan Rincian Barang) ---
        // Kita hitung manual: Jumlah Barang x Harga Jual (dari tabel produk)
        // Ini melewati tabel 'sales' yang bermasalah tadi.
        $queryOmzet = $db->query("
            SELECT SUM(products.harga_jual * sale_items.$kolomQty) as total_omzet 
            FROM sale_items 
            JOIN products ON sale_items.product_id = products.id
        ");
        $omzet = $queryOmzet->getRow()->total_omzet ?? 0;

        // --- B. HITUNG MODAL (HPP) ---
        // Rumus: Jumlah Barang x Harga Beli
        $queryModal = $db->query("
            SELECT SUM(products.harga_beli * sale_items.$kolomQty) as total_modal 
            FROM sale_items 
            JOIN products ON sale_items.product_id = products.id
        ");
        $modal = $queryModal->getRow()->total_modal ?? 0;

        // --- C. HITUNG GAJI (History Payroll) ---
        $queryGaji = $db->query("SELECT SUM(total_gaji_bersih) as total FROM payroll");
        $gaji = $queryGaji->getRow()->total ?? 0;

        // --- D. LABA BERSIH FINAL ---
        $laba_bersih = $omzet - $modal - $gaji;

        // --- E. DATA PENDUKUNG ---
        $total_karyawan = $db->table('employees')->countAllResults();
        $total_produk   = $db->table('products')->countAllResults();

        // Kirim Data
        $data = [
            'title' => 'Dashboard Utama',
            'user_role' => session()->get('role'),
            
            'total_penjualan' => $omzet,
            'laba_bersih'     => $laba_bersih,
            'total_karyawan'  => $total_karyawan,
            'total_produk'    => $total_produk, 
        ];

        return view('overview', $data);
    }
}