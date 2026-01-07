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
        // 1. Panggil Model
        $employeeModel = new \App\Models\EmployeeModel(); // Model Karyawan
        $userModel = new \App\Models\UserModel();         // Model User
        
        // 2. Ambil Data dari Form Admin
        $nama    = $this->request->getPost('nama_lengkap');
        $posisi  = $this->request->getPost('posisi');
        $gaji    = $this->request->getPost('gaji_pokok');
        $tunj    = $this->request->getPost('tunjangan');
        $hp      = $this->request->getPost('no_hp');

        // 3. Simpan ke Tabel Employees (Data Karyawan)
        $employeeModel->save([
            'nama_lengkap' => $nama,
            'posisi'       => $posisi,
            'gaji_pokok'   => $gaji,
            'tunjangan'    => $tunj,
            'no_hp'        => $hp
        ]);

        // 4. OTOMATIS BUAT AKUN LOGIN (Tabel Users)
        // Kita bikin username otomatis dari nama (huruf kecil, tanpa spasi)
        // Contoh: "Wira Ganteng" jadi "wiraganteng"
        $usernameAuto = strtolower(str_replace(' ', '', $nama));
        
        // Cek dulu apakah username sudah ada? Kalau ada tambah angka acak
        if ($userModel->where('username', $usernameAuto)->first()) {
            $usernameAuto .= rand(10, 99);
        }

        $userModel->save([
            'username'     => $usernameAuto,
            'password'     => password_hash('password123', PASSWORD_DEFAULT), // Password Default
            'role'         => strtolower(str_replace(' ', '_', $posisi)), // Sesuaikan format role (misal: Staff Gudang -> staff_gudang)
            'nama_lengkap' => $nama,
            'foto'         => 'default.png'
        ]);

        return redirect()->to('/karyawan')->with('success', 'Karyawan berhasil ditambahkan & Akun Login otomatis dibuat (Pass: password123)');
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