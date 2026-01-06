<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\PayrollModel;

class Laporan extends BaseController
{
    public function index()
    {
        $saleModel = new SaleModel();
        $saleItemModel = new SaleItemModel();
        $payrollModel = new PayrollModel();
        
        // 1. Hitung Total Pemasukan (Omzet Penjualan)
        $queryPenjualan = $saleModel->selectSum('grand_total')->get()->getRow();
        $total_penjualan = $queryPenjualan->grand_total ?? 0;

        // 2. Hitung Total Pengeluaran Gaji
        $queryGaji = $payrollModel->selectSum('total_gaji_bersih')->get()->getRow();
        $total_gaji = $queryGaji->total_gaji_bersih ?? 0;

        // 3. Hitung Modal Barang (HPP) - Agak Advance
        // Kita butuh join tabel sale_items dengan products untuk tahu harga beli aslinya
        $db = \Config\Database::connect();
        $queryModal = $db->query("
            SELECT SUM(sale_items.qty * products.harga_beli) as total_modal 
            FROM sale_items 
            JOIN products ON sale_items.product_id = products.id
        ");
        $total_modal = $queryModal->getRow()->total_modal ?? 0;

        // 4. Hitung Laba Bersih
        $laba_bersih = $total_penjualan - ($total_modal + $total_gaji);

        $data = [
            'title'           => 'Laporan Keuangan',
            'total_penjualan' => $total_penjualan,
            'total_modal'     => $total_modal,
            'total_gaji'      => $total_gaji,
            'laba_bersih'     => $laba_bersih,
            // Kita kirim juga data transaksi terakhir buat tabel
            'recent_sales'    => $saleModel->orderBy('id', 'DESC')->findAll(5) 
        ];

        return view('laporan/index', $data);
    }
}