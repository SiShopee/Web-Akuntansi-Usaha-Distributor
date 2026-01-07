<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StockHistoryModel;

class Riwayat extends BaseController
{
    public function index()
    {
        // Panggil Model Riwayat yang sudah kita buat di langkah sebelumnya
        $model = new StockHistoryModel();
        
        // Ambil data gabungan (History + Nama Barang)
        $data_history = $model->getHistoryWithProduct();

        $data = [
            'title'   => 'Riwayat Arus Barang',
            'history' => $data_history
        ];

        return view('riwayat/index', $data);
    }
}