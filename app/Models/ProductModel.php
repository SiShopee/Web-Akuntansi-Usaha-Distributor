<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Sesuai kolom di database yang kita buat tadi
    protected $allowedFields    = ['nama_barang', 'kode_barang', 'harga_beli', 'harga_jual', 'stok', 'deleted_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    // Aktifkan soft deletes untuk menjaga integritas laporan keuangan
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';
    protected $dateFormat     = 'datetime';
}