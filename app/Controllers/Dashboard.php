<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\PayrollModel;
use App\Models\EmployeeModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Cek login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Panggil semua model yang dibutuhkan
        $saleModel = new SaleModel();
        $employeeModel = new EmployeeModel();
        $payrollModel = new PayrollModel();

        // 1. Hitung Total Penjualan (Omzet)
        $queryPenjualan = $saleModel->selectSum('grand_total')->get()->getRow();
        $total_penjualan = $queryPenjualan->grand_total ?? 0;

        // 2. Hitung Jumlah Karyawan Aktif
        $total_karyawan = $employeeModel->countAll();

        // 3. Hitung Laba Bersih (Sederhana)
        // a. Total Beban Gaji
        $queryGaji = $payrollModel->selectSum('total_gaji_bersih')->get()->getRow();
        $total_gaji = $queryGaji->total_gaji_bersih ?? 0;
        
        // b. Total Modal Barang (HPP)
        $db = \Config\Database::connect();
        $queryModal = $db->query("
            SELECT SUM(sale_items.qty * products.harga_beli) as total_modal 
            FROM sale_items 
            JOIN products ON sale_items.product_id = products.id
        ");
        $total_modal = $queryModal->getRow()->total_modal ?? 0;

        // c. Rumus Laba
        $laba_bersih = $total_penjualan - ($total_modal + $total_gaji);

        // Kirim data ke View
        $data = [
            'title'           => 'Dashboard Utama',
            'user_role'       => session()->get('role'),
            'total_penjualan' => $total_penjualan,
            'laba_bersih'     => $laba_bersih,
            'total_karyawan'  => $total_karyawan
        ];

        return view('overview', $data);
    }
}