<?php

namespace App\Models;

use CodeIgniter\Model;

class PayrollModel extends Model
{
    protected $table            = 'payroll';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['employee_id', 'bulan_tahun', 'total_hadir', 'potongan', 'total_gaji_bersih', 'tanggal_generate'];

    // Fungsi untuk mengambil data gaji beserta nama karyawannya
    public function getPayrollWithNames()
    {
        return $this->select('payroll.*, employees.nama_lengkap, employees.posisi')
                    ->join('employees', 'employees.id = payroll.employee_id')
                    ->orderBy('payroll.id', 'DESC')
                    ->findAll();
    }
}