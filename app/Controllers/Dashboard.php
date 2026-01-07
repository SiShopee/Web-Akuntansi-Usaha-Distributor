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
        // 1. Cek Login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // 2. Panggil Model
        $saleModel = new SaleModel();       // <--- Namanya $saleModel
        $employeeModel = new EmployeeModel();
        $payrollModel = new PayrollModel();
        $productModel = new \App\Models\ProductModel(); 

        // 3. Siapkan Data
        $data = [
            'title' => 'Dashboard Utama',
            'user_role' => session()->get('role'),
            
            // Data untuk Admin/Kasir
            // PERBAIKAN: Gunakan $saleModel, bukan $transaksiModel
            'total_penjualan' => $saleModel->selectSum('total_harga')->first()['total_harga'] ?? 0,
            
            // Data untuk Admin/HR
            'total_karyawan'  => $employeeModel->countAllResults(),
            
            // Data untuk Staff Gudang (Hitung jumlah barang)
            'total_produk'    => $productModel->countAllResults(), 
            
            // Hitung Laba Bersih
            // Rumus: (Total Omzet - Total Modal Barang Terjual) - Total Gaji Karyawan
            'laba_bersih'     => ($saleModel->selectSum('total_harga')->first()['total_harga'] ?? 0)
                                 - 
                                 ($saleModel->join('sale_items', 'sales.id = sale_items.sale_id')
                                            ->join('products', 'sale_items.product_id = products.id')
                                            ->selectSum('products.harga_beli', 'total_modal') // Kita ambil harga beli asli dari tabel produk
                                            ->first()['total_modal'] ?? 0)
                                 - 
                                 ($employeeModel->selectSum('gaji_pokok')->first()['gaji_pokok'] ?? 0)
        ];

        return view('overview', $data);
    }
}