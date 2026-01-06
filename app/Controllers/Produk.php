<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

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
        // 1. Ambil semua data barang dari database
        $data_barang = $this->productModel->findAll();

        $data = [
            'title' => 'Data Barang',
            'products' => $data_barang
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
        // 2. Simpan data dari form ke database
        $this->productModel->save([
            'nama_barang' => $this->request->getPost('nama_barang'),
            'kode_barang' => $this->request->getPost('kode_barang'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'stok'        => $this->request->getPost('stok'),
        ]);

        return redirect()->to('/produk');
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        return redirect()->to('/produk');
    }
}