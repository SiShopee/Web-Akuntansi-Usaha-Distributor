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

    // --- FITUR EDIT DATA KARYAWAN ---

    public function edit($id)
    {
        // 1. Cari data karyawan berdasarkan ID
        $karyawan = $this->employeeModel->find($id);

        if (!$karyawan) {
            return redirect()->to('/karyawan')->with('error', 'Data karyawan tidak ditemukan.');
        }

        $data = [
            'title'     => 'Edit Data Karyawan',
            'user_role' => session()->get('role'),
            'karyawan'  => $karyawan
        ];

        return view('karyawan/edit', $data);
    }

    public function update($id)
    {
        // 2. Proses Simpan Perubahan
        $this->employeeModel->save([
            'id'           => $id, // KUNCI UTAMA: ID harus ada biar sistem tau ini UPDATE, bukan INSERT
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'posisi'       => $this->request->getPost('posisi'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'gaji_pokok'   => $this->request->getPost('gaji_pokok'),
            'tunjangan'    => $this->request->getPost('tunjangan'),
        ]);

        return redirect()->to('/karyawan')->with('success', 'Data karyawan berhasil diperbarui!');
    }
    
    // --- FITUR HAPUS (Bonus, biar lengkap) ---
    public function delete($id)
    {
        $this->employeeModel->delete($id);
        return redirect()->to('/karyawan')->with('success', 'Data karyawan berhasil dihapus.');
    }

}