<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\StockHistoryModel;

class Riwayat extends BaseController
{
    // 1. FUNGSI MENAMPILKAN HALAMAN RIWAYAT (YANG TADINYA HILANG)
    public function index()
    {
        $historyModel = new StockHistoryModel();
        
        // Ambil data history digabung dengan nama barang
        // Kita join tabel 'stock_history' dengan 'products'
        $data = [
            'title'   => 'Riwayat Keluar Masuk Stok',
            'riwayat' => $historyModel->select('stock_histories.*, products.nama_barang, products.kode_barang')
                                      ->join('products', 'products.id = stock_histories.product_id', 'left')
                                      ->orderBy('stock_histories.created_at', 'DESC')
                                      ->findAll()
        ];
	
        // Pastikan kamu punya file view di: app/Views/riwayat/index.php
        return view('riwayat/index', $data);
    }

    // 2. FUNGSI TAMBAH STOK (YANG SUDAH ADA)
    public function add_stok()
    {
        $productModel = new ProductModel();
        $historyModel = new StockHistoryModel();

        // 1. Ambil Data dari Form
        $id_barang  = $this->request->getPost('product_id');
        $qty_masuk  = $this->request->getPost('qty');
        $keterangan = $this->request->getPost('keterangan');

        // 2. Cek Barang Lama
        $barang = $productModel->find($id_barang);
        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan!');
        }

        // 3. Update Stok di Tabel Produk (Bertambah)
        $stok_baru = $barang['stok'] + $qty_masuk;
        $productModel->update($id_barang, ['stok' => $stok_baru]);

        // 4. Catat di Riwayat (History) & TAMPUNG HASILNYA KE VARIABEL $simpan
        $simpan = $historyModel->save([
            'product_id' => $id_barang,
            'type'       => 'masuk', 
            'qty'        => $qty_masuk,
            'keterangan' => $keterangan,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 5. Cek Apakah Gagal?
        if (!$simpan) {
            // Jika gagal, tampilkan error di layar biar kita tahu alasannya
            dd($historyModel->errors());
        }

        return redirect()->to('/produk')->with('success', 'Stok berhasil ditambahkan!');
    }
}
