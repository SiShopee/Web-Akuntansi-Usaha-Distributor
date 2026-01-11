<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\AttendanceModel;
use App\Models\PayrollModel;

class Gaji extends BaseController
{
    public function index()
    {
        $payrollModel = new PayrollModel();
        $data = [
            'title'   => 'Data Penggajian',
            'payroll' => $payrollModel->getPayrollWithNames()
        ];
        return view('gaji/index', $data);
    }

    public function create()
    {
        $employeeModel = new EmployeeModel();
        $data = [
            'title'     => 'Hitung Gaji Karyawan',
            'employees' => $employeeModel->findAll()
        ];
        return view('gaji/create', $data);
    }

    public function process()
    {
        $employeeModel   = new EmployeeModel();
        $payrollModel    = new PayrollModel(); // AttendanceModel tidak perlu diload jika pakai manual query

        $employee_id = $this->request->getPost('employee_id');
        $bulan       = $this->request->getPost('bulan'); // Format: 2026-01

        // 1. Ambil Data Karyawan (Untuk tahu Gaji Pokok & NAMANYA)
        $karyawan = $employeeModel->find($employee_id);
        
        // Ambil nama untuk dicocokkan ke tabel absensi
        $nama_target = $karyawan['nama_lengkap']; 

        // 2. Hitung Absensi (Mencocokkan Nama, BUKAN ID)
        $db = \Config\Database::connect();
        
        // A. Hitung ALPA
        // Perhatikan: Kita ganti 'employee_id' menjadi 'nama_karyawan'
        $queryAlpa = $db->query("SELECT COUNT(*) as jumlah_alpa FROM attendance 
                             WHERE nama_karyawan = '$nama_target' 
                             AND status = 'alpa'
                             AND DATE_FORMAT(tanggal, '%Y-%m') = '$bulan'");
        $jumlah_alpa = $queryAlpa->getRow()->jumlah_alpa;

        // B. Hitung HADIR (Opsional)
        $queryHadir = $db->query("SELECT COUNT(*) as jumlah_hadir FROM attendance 
                             WHERE nama_karyawan = '$nama_target'
                             AND status = 'hadir'
                             AND DATE_FORMAT(tanggal, '%Y-%m') = '$bulan'");
        $total_hadir = $queryHadir->getRow()->jumlah_hadir;

        // 3. RUMUS GAJI
        $denda_per_alpa = 100000; 
        $total_potongan = $jumlah_alpa * $denda_per_alpa;

        $gaji_kotor  = $karyawan['gaji_pokok'] + $karyawan['tunjangan'];
        $gaji_bersih = $gaji_kotor - $total_potongan;

        // 4. Simpan ke Database Payroll
        $payrollModel->save([
            'employee_id'       => $employee_id,
            'bulan_tahun'       => $bulan,
            'total_hadir'       => $total_hadir,
            'potongan'          => $total_potongan,
            'total_gaji_bersih' => $gaji_bersih
        ]);

        return redirect()->to('/gaji')->with('success', "Gaji berhasil dihitung! Total Alpa: $jumlah_alpa kali. Potongan: Rp " . number_format($total_potongan));
    }
}
