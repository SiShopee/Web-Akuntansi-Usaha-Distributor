<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table            = 'attendance';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = false; 
    protected $allowedFields    = ['user_id', 'nama_karyawan', 'tanggal', 'jam_masuk', 'status'];

    // --- FUNGSI TAMBAHAN (Penyelamat Error) ---
    // Fungsi ini dipanggil oleh Controller 'Absensi' untuk menampilkan daftar hadir
    public function getAttendanceWithNames()
    {
        // Karena tabel kita sekarang sudah punya kolom 'nama_karyawan',
        // Kita tidak perlu JOIN rumit lagi. Cukup ambil semua dan urutkan terbaru.
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
}
