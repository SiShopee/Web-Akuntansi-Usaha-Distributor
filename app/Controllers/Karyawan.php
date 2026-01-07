<?php

namespace App\Controllers;

use App\Models\EmployeeModel; // Panggil model karyawan yang kita buat di awal

class Karyawan extends BaseController
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Karyawan',
            'employees' => $this->employeeModel->findAll()
        ];

        return view('karyawan/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Karyawan'];
        return view('karyawan/create', $data);
    }

    public function store()
    {
        // 1. Simpan Data Karyawan (Kode Lama)
        $nama = $this->request->getPost('nama_lengkap');
        $posisi = $this->request->getPost('posisi');

        $this->employeeModel->save([
            'nama_lengkap' => $nama,
            'posisi'       => $posisi,
            'no_hp'        => $this->request->getPost('no_hp'),
            'gaji_pokok'   => $this->request->getPost('gaji_pokok'),
            'tunjangan'    => $this->request->getPost('tunjangan'),
        ]);

        // 2. [BARU] Buatkan Akun Login Otomatis
        $userModel = new \App\Models\UserModel();
        
        // Ambil kata pertama nama sebagai username (biar simpel)
        $arrNama = explode(' ', trim($nama));
        $username = strtolower($arrNama[0]);
        
        // Normalisasi role (posisi di karyawan -> role di users)
        $role = 'karyawan';
        if(stripos($posisi, 'Kasir') !== false) $role = 'kasir';
        if(stripos($posisi, 'Sales') !== false) $role = 'sales';
        if(stripos($posisi, 'Gudang') !== false) $role = 'staff_gudang';

        // Cek dulu user sudah ada belum, kalau belum buatkan
        if (!$userModel->where('username', $username)->first()) {
            $userModel->save([
                'username' => $username,
                'password' => password_hash('password123', PASSWORD_DEFAULT), // Default
                'role'     => $role
            ]);
        }

        return redirect()->to('/karyawan')->with('success', 'Karyawan & Akun Login berhasil dibuat.');
    }

    public function delete($id)
    {
        $this->employeeModel->delete($id);
        return redirect()->to('/karyawan')->with('success', 'Data karyawan dihapus.');
    }
}