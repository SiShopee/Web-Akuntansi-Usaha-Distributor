<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table            = 'attendance';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['employee_id', 'tanggal', 'status', 'jam_masuk', 'jam_keluar'];
    
    // Kita butuh fungsi khusus untuk mengambil nama karyawan sekalian (JOIN Table)
    public function getAttendanceWithNames()
    {
        return $this->select('attendance.*, employees.nama_lengkap, employees.posisi')
                    ->join('employees', 'employees.id = attendance.employee_id')
                    ->orderBy('attendance.tanggal', 'DESC')
                    ->findAll();
    }
}