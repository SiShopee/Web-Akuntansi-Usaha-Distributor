<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';          // Nama tabel di database
    protected $primaryKey       = 'id';             // Primary key
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';          // Data dikembalikan dalam bentuk array
    
    // Fitur keamanan: Hanya kolom ini yang boleh diisi lewat kodingan
    protected $allowedFields    = ['username', 'password', 'role'];

    // Aktifkan fitur tanggal otomatis (created_at)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kita tidak pakai updated_at di tabel tadi
}