<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\PayrollModel;

class Laporan extends BaseController
{
    public function index()
    {
        // 1. Cek Login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // --- A. DETEKSI NAMA KOLOM DULU (Wajib di Awal) ---
        
        // Cek Nama Kolom Quantity (qty atau quantity?)
        if ($db->fieldExists('quantity', 'sale_items')) {
            $kolomQty = 'quantity';
        } else {
            $kolomQty = 'qty';
        }

        // Cek Nama Kolom Produk (nama, nama_barang, dll)
        if ($db->fieldExists('nama_barang', 'products')) {
            $kolomNama = 'nama_barang'; // Sesuai databasemu
        } else {
            $kolomNama = 'nama_produk';
        }

        // --- B. HITUNG OMZET (Metode "Scan Barang" - Paling Akurat) ---
        // Kita hitung: Jumlah Barang x Harga Jual (mengabaikan tabel 'sales' yang error 0)
        $queryOmzet = $db->query("
            SELECT SUM(products.harga_jual * sale_items.$kolomQty) as total_omzet 
            FROM sale_items 
            JOIN products ON sale_items.product_id = products.id
        ");
        $omzet = $queryOmzet->getRow()->total_omzet ?? 0;

        // --- C. HITUNG MODAL (HPP) ---
        $queryModal = $db->query("
            SELECT SUM(products.harga_beli * sale_items.$kolomQty) as total_modal 
            FROM sale_items 
            JOIN products ON sale_items.product_id = products.id
        ");
        $modal = $queryModal->getRow()->total_modal ?? 0;

        // --- D. HITUNG GAJI ---
        $queryGaji = $db->query("SELECT SUM(total_gaji_bersih) as total FROM payroll");
        $gaji = $queryGaji->getRow()->total ?? 0;

        // --- E. LABA BERSIH ---
        $laba_bersih = $omzet - $modal - $gaji;

        // --- F. AMBIL TOP 5 PRODUK ---
        $queryTop = $db->query("
            SELECT 
                products.$kolomNama as nama_produk, 
                SUM(sale_items.$kolomQty) as terjual, 
                SUM(sale_items.subtotal) as total_uang
            FROM sale_items
            JOIN products ON sale_items.product_id = products.id
            GROUP BY products.id
            ORDER BY terjual DESC
            LIMIT 5
        ");
        $top_products = $queryTop->getResultArray();

        // Kirim Data
        $data = [
            'title' => 'Laporan Keuangan',
            'user_role' => session()->get('role'),
            'omzet' => $omzet,
            'modal' => $modal,
            'gaji'  => $gaji,
            'laba'  => $laba_bersih,
            'top_products' => $top_products
        ];

        return view('laporan_view', $data);
    }
}