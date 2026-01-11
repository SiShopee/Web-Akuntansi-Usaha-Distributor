<?php

namespace App\Models;

use CodeIgniter\Model;

class StockHistoryModel extends Model
{
    // 1. Pastikan nama tabel PLURAL (akhiran 'es') sesuai screenshot kamu
    protected $table            = 'stock_histories'; 
    
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // 2. WAJIB ADA: Satpam yang mengizinkan data masuk
    // Kalau ini kosong/salah, data tidak akan tersimpan!
    protected $allowedFields    = [
        'product_id', 
        'type', 
        'qty', 
        'keterangan', 
        'created_at'
    ];
}
