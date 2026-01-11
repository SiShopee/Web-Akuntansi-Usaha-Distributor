<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = false; // Sesuaikan dengan settinganmu
    
    // INI YANG HARUS DIUPDATE:
    protected $allowedFields    = [
        'no_faktur', 
        'tanggal', 
        'user_id', 
        'grand_total',
        
        // Tambahkan 2 anak baru ini agar bisa masuk database:
        'total_harga', 
        'pajak'
    ];
}
