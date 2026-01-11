<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToProducts extends Migration
{
    public function up()
    {
        // Tambah kolom deleted_at jika belum ada
        if (! $this->db->fieldExists('deleted_at', 'products')) {
            $fields = [
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'default' => null,
                ],
            ];

            $this->forge->addColumn('products', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('deleted_at', 'products')) {
            $this->forge->dropColumn('products', 'deleted_at');
        }
    }
}
