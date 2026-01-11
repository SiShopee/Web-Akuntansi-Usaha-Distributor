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

        // --- A. DETEKSI NAMA KOLOM (Agar error-proof) ---
        // Cek Nama Kolom Quantity (qty vs quantity)
        $kolomQty = $db->fieldExists('quantity', 'sale_items') ? 'quantity' : 'qty';
        
        // Cek Nama Kolom Produk (nama_barang vs nama_produk)
        $kolomNama = $db->fieldExists('nama_barang', 'products') ? 'nama_barang' : 'nama_produk';


        // --- B. HITUNG OMZET MURNI & PAJAK (SUM dari Tabel Sales) ---
        // Kita ambil data dari tabel 'sales' karena di sana sudah tersimpan 
        // harga deal saat transaksi terjadi (Subtotal) dan Pajaknya.
        $querySales = $db->query("
            SELECT 
                SUM(total_harga) as omzet_murni, 
                SUM(pajak) as total_pajak 
            FROM sales
        ");
        $rowSales = $querySales->getRow();

        // Gunakan null coalescing (?? 0) jaga-jaga kalau tabel kosong
        $omzet      = $rowSales->omzet_murni ?? 0;
        $totalPajak = $rowSales->total_pajak ?? 0;


        // --- C. HITUNG MODAL BARANG (HPP) ---
        // Rumus: Jumlah barang terjual x Harga Beli (Modal)
        // Kita masih pakai tabel products untuk harga beli
        $queryModal = $db->query("
            SELECT SUM(products.harga_beli * sale_items.$kolomQty) as total_modal
            FROM sale_items
            JOIN products ON sale_items.product_id = products.id
        ");
        $modal = $queryModal->getRow()->total_modal ?? 0;


        // --- D. HITUNG BEBAN GAJI ---
        $queryGaji = $db->query("SELECT SUM(total_gaji_bersih) as total FROM payroll");
        $gaji = $queryGaji->getRow()->total ?? 0;


        // --- E. LABA BERSIH USAHA ---
        // Rumus: Omzet Murni - Modal Barang - Gaji Karyawan
        // (Pajak tidak dihitung karena itu uang titipan negara)
        $laba_bersih = $omzet - $modal - $gaji;


        // --- F. TOP 5 PRODUK TERLARIS ---
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

        // Kirim Data ke View
        $data = [
            'title'        => 'Laporan Keuangan',
            'user_role'    => session()->get('role'),
            
            'omzet'        => $omzet,       // Uang Masuk Toko
            'total_pajak'  => $totalPajak,  // Tambahan: Uang Pajak (display only)
            'modal'        => $modal,       // HPP
            'gaji'         => $gaji,        // Beban Gaji
            'laba'         => $laba_bersih, // Keuntungan Bersih
            
            'top_products' => $top_products
        ];

        return view('laporan_view', $data);
    }
}
