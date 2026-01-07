<?php

namespace App\Models;

use CodeIgniter\Model;

class StockHistoryModel extends Model
{
    protected $table            = 'stock_histories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['product_id', 'type', 'qty', 'keterangan'];

    // Join ke tabel produk biar tahu nama barangnya apa
    public function getHistoryWithProduct()
    {
        return $this->select('stock_histories.*, products.nama_barang, products.kode_barang')
                    ->join('products', 'products.id = stock_histories.product_id')
                    ->orderBy('stock_histories.id', 'DESC')
                    ->findAll();
    }
}