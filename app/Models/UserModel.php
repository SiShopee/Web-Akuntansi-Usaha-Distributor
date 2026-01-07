<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    
    // BAGIAN PENTING: Tambahkan 'nama_lengkap' dan 'foto' di sini!
    protected $allowedFields    = [
        'username', 
        'password', 
        'role', 
        'nama_lengkap', // <--- Tambahkan ini
        'foto'          // <--- Tambahkan ini
    ];

    // ... (kode di bawahnya biarkan saja)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // kosongkan jika tidak pakai updated_at
}