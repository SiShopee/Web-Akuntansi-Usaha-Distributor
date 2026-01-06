<?php

namespace App\Controllers;

use App\Models\ProductModel; // Panggil model yang tadi dibuat

class CekDatabase extends BaseController
{
    public function index()
    {
        $model = new ProductModel();

        // Ambil semua data produk
        $semua_produk = $model->findAll();

        // Tampilkan di layar (dd = dump and die)
        dd($semua_produk);
    }
}