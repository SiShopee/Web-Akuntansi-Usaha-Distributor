<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\StockHistoryModel;

class Produk extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        // Load Model Barang yang sudah kita buat di awal
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        // 1. Cek Login (Sudah ada)
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // --- 2. CEK JABATAN (SECURITY BARU) ---
        // Jika jabatannya Kasir ATAU Sales, tendang balik ke Dashboard!
        $role = session()->get('role');
        if ($role == 'kasir' || $role == 'sales') {
            return redirect()->to('/dashboard')->with('error', 'Akses Ditolak! Anda bukan Staff Gudang.');
        }

        // ... (Kode query produk ke bawah biarkan seperti biasa) ...
        $productModel = new \App\Models\ProductModel();
        $data = [
            'title' => 'Data Barang',
            'products' => $productModel->findAll()
        ];

        return view('produk/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Barang Baru'];
        return view('produk/create', $data);
    }

    public function store()
    {
        // 1. Simpan data ke tabel products
        $this->productModel->save([
            'nama_barang' => $this->request->getPost('nama_barang'),
            'kode_barang' => $this->request->getPost('kode_barang'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'stok'        => $this->request->getPost('stok'),
        ]);

        // 2. Ambil ID barang yang barusan dibuat
        $newID = $this->productModel->getInsertID();

        // 3. Catat otomatis ke tabel stock_histories
        $historyModel = new \App\Models\StockHistoryModel();
        $historyModel->save([
            'product_id' => $newID,
            'type'       => 'masuk',
            'qty'        => $this->request->getPost('stok'),
            'keterangan' => 'Stok Awal Barang Baru'
        ]);

        return redirect()->to('/produk')->with('success', 'Barang berhasil ditambahkan & tercatat di riwayat!');
    }

    public function delete($id)
    {
        // Pastikan data ada
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/produk')->with('error', 'Data barang tidak ditemukan.');
        }

        // Lakukan soft-delete (karena ProductModel sudah pakai $useSoftDeletes)
        $this->productModel->delete($id);
        return redirect()->to('/produk')->with('success', 'Barang berhasil dinonaktifkan (soft-delete).');
    }

    public function restock($id)
    {
        $model = new \App\Models\ProductModel(); // Pastikan pakai \ (backslash) jika error
        $data = [
            'title'   => 'Restock Barang Masuk',
            'product' => $model->find($id)
        ];
        return view('produk/restock', $data);
    }

    // Proses Simpan Restock
    public function process_restock()
    {
        $productModel = new \App\Models\ProductModel();
        $historyModel = new \App\Models\StockHistoryModel();

        $id  = $this->request->getPost('id');
        $qty = $this->request->getPost('qty');
        $ket = $this->request->getPost('keterangan');

        // 1. Update Stok di Master Produk (Bertambah)
        $product = $productModel->find($id);
        $newStock = $product['stok'] + $qty;
        $productModel->update($id, ['stok' => $newStock]);

        // 2. Catat Riwayat Masuk
        $historyModel->save([
            'product_id' => $id,
            'type'       => 'masuk',
            'qty'        => $qty,
            'keterangan' => $ket
        ]);

        return redirect()->to('/produk')->with('success', 'Stok berhasil ditambahkan!');
    }

    // Fungsi untuk memproses Edit Barang
    public function update($id)
    {
        $productModel = new \App\Models\ProductModel();

        // 1. Ambil data dari Form Modal
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            // Stok tidak kita update disini demi keamanan akuntansi
        ];

        // 2. Update ke Database
        $productModel->update($id, $data);

        // 3. Kembali ke halaman produk
        return redirect()->to('/produk')->with('success', 'Data barang berhasil diperbarui!');
    }

}
