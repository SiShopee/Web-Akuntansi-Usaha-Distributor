<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\ProductModel;
use CodeIgniter\Controller;
use App\Models\StockHistoryModel;

class Transaksi extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        
        $data = [
            'title'     => 'Kasir Penjualan',
            'products'  => $productModel->where('stok >', 0)->findAll(), // Hanya ambil barang yg ada stoknya
            'cart'      => session()->get('cart') ?? [] // Ambil keranjang dari session
        ];

        return view('transaksi/view_kasir', $data);
    }

    // Fungsi 1: Masukkan barang ke keranjang sementara
    public function add_to_cart()
    {
        $productModel = new ProductModel();
        $productId = $this->request->getPost('product_id');
        $qty       = $this->request->getPost('qty');

        // Ambil data barang asli dari DB
        $product = $productModel->find($productId);

        if ($product) {
            $cart = session()->get('cart') ?? [];

            // Cek apakah barang sudah ada di keranjang?
            if (isset($cart[$productId])) {
                $cart[$productId]['qty'] += $qty; // Kalau ada, tambahkan jumlahnya
            } else {
                $cart[$productId] = [
                    'id'    => $product['id'],
                    'name'  => $product['nama_barang'],
                    'price' => $product['harga_jual'],
                    'qty'   => $qty
                ];
            }

            // Simpan update keranjang ke session
            session()->set('cart', $cart);
        }
        
        return redirect()->to('/transaksi');
    }

    // Fungsi 2: Hapus keranjang (Reset)
    public function clear_cart()
    {
        session()->remove('cart');
        return redirect()->to('/transaksi');
    }
    
    public function process_payment()
    {
        $cart = session()->get('cart');

        if (empty($cart)) {
            return redirect()->to('/transaksi')->with('error', 'Keranjang belanja kosong!');
        }

        // 1. Hitung Subtotal & PPN
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['qty']);
        }

        $tarif_ppn = 0.11;
        $pajak     = $subtotal * $tarif_ppn; 
        $grand_total = $subtotal + $pajak;

        // 2. Siapkan Model
        $saleModel = new \App\Models\SaleModel();
        $saleItemModel = new \App\Models\SaleItemModel();
        $productModel = new \App\Models\ProductModel();
        $stockHistoryModel = new \App\Models\StockHistoryModel(); 

        $db = \Config\Database::connect();
        $db->transStart();

        // 3. Simpan ke Database Penjualan
        $saleData = [
            'no_faktur'   => 'INV-' . date('YmdHis'),
            'tanggal'     => date('Y-m-d H:i:s'),
            'total_harga' => $subtotal,    
            'pajak'       => $pajak,       
            'grand_total' => $grand_total, 
            'user_id'     => session()->get('id')
        ];

        $saleModel->insert($saleData);
        $sale_id = $saleModel->getInsertID();

        // 4. Simpan Item & Kurangi Stok & CATAT RIWAYAT
        foreach ($cart as $item) {
            // A. Simpan Detail Item
            $saleItemModel->insert([
                'sale_id'        => $sale_id,
                'product_id'     => $item['id'],
                'qty'            => $item['qty'],
                'harga_saat_ini' => $item['price'],
                'subtotal'       => $item['price'] * $item['qty']
            ]);

            // B. Update Stok di Tabel Produk
            $currentProduct = $productModel->find($item['id']);
            if($currentProduct) {
                $newStock = $currentProduct['stok'] - $item['qty'];
                $productModel->update($item['id'], ['stok' => $newStock]);
            }

            // C. CATAT RIWAYAT STOK (INI YANG TADINYA MATI)
            $stockHistoryModel->save([
                'product_id' => $item['id'],
                
                // PENTING: Kita paksa labelnya 'keluar' agar warnanya MERAH
                'type'       => 'keluar', 
                
                'qty'        => $item['qty'],
                'keterangan' => 'Penjualan No: ' . $saleData['no_faktur'], 
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi Gagal!');
        } else {
            session()->remove('cart');
            return redirect()->to('/transaksi')->with('success', 'Transaksi Berhasil! Stok tercatat keluar.');
        }
    }

}
