<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\ProductModel;
use CodeIgniter\Controller;

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

        // 1. Cek apakah keranjang kosong?
        if (empty($cart)) {
            return redirect()->to('/transaksi')->with('error', 'Keranjang belanja kosong!');
        }

        // 2. Hitung Grand Total
        $grand_total = 0;
        foreach ($cart as $item) {
            $grand_total += ($item['price'] * $item['qty']);
        }

        // 3. Siapkan Model
        $saleModel = new SaleModel();
        $saleItemModel = new SaleItemModel();
        $productModel = new ProductModel();

        // 4. Mulai Database Transaction (Supaya aman, kalau gagal 1 batal semua)
        $db = \Config\Database::connect();
        $db->transStart();

        // A. SIMPAN DATA KE TABEL SALES (Header)
        $saleData = [
            'no_faktur'   => 'INV-' . date('YmdHis'), // Contoh: INV-202601070300
            'tanggal'     => date('Y-m-d H:i:s'),
            'grand_total' => $grand_total,
            'user_id'     => session()->get('id') // ID kasir yang sedang login
        ];
        $saleModel->insert($saleData);
        $sale_id = $saleModel->getInsertID(); // Ambil ID transaksi yang baru dibuat

        // B. SIMPAN RINCIAN BARANG & KURANGI STOK
        foreach ($cart as $item) {
            // Simpan ke sale_items
            $saleItemModel->insert([
                'sale_id'       => $sale_id,
                'product_id'    => $item['id'],
                'qty'           => $item['qty'],
                'harga_saat_ini'=> $item['price'],
                'subtotal'      => $item['price'] * $item['qty']
            ]);

            // Kurangi Stok di tabel products
            // Ambil stok lama dulu
            $currentProduct = $productModel->find($item['id']);
            $newStock = $currentProduct['stok'] - $item['qty'];

            // Update stok baru
            $productModel->update($item['id'], ['stok' => $newStock]);
        }

        $db->transComplete(); // Selesai transaksi

        if ($db->transStatus() === FALSE) {
            // Jika gagal
            return redirect()->to('/transaksi')->with('error', 'Transaksi Gagal Disimpan!');
        } else {
            // Jika sukses: Hapus keranjang & Tampilkan pesan sukses
            session()->remove('cart');
            return redirect()->to('/transaksi')->with('success', 'Transaksi Berhasil! Stok sudah dikurangi.');
        }
    }
}