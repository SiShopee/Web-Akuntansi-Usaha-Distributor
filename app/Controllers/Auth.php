<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // --- HALAMAN LOGIN ---
    public function index()
    {
        return view('login_view');
    }

    public function process_login()
        {
            $model = new \App\Models\UserModel();
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            $roleInput = strtolower(trim($this->request->getPost('role')));

            $user = $model->where('username', $username)->first();

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    
                    $roleDb = strtolower(trim($user['role']));
                    if ($roleDb == 'admin') $roleDb = 'pemilik';

                    if ($roleDb == $roleInput) {
                        $sessData = [
                            'id' => $user['id'],
                            'username' => $user['username'],
                            'role' => $user['role'],
                            'isLoggedIn' => true
                        ];
                        session()->set($sessData);
                        return redirect()->to('/dashboard');
                    } else {
                        // Pesan error detail (bantu kalau error lagi)
                        return redirect()->back()->with('error', "Jabatan salah! Database mencatat anda sebagai: " . ($roleDb ?: 'KOSONG'));
                    }

                } else {
                    return redirect()->back()->with('error', 'Password salah!');
                }
            } else {
                return redirect()->back()->with('error', 'Username tidak ditemukan!');
            }
        }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // --- HALAMAN REGISTRASI ---
    public function register()
    {
        return view('register_view');
    }

    public function process_register()
    {
        $userModel = new UserModel();
        $employeeModel = new \App\Models\EmployeeModel(); // Panggil model karyawan

        // Ambil input
        $nama     = $this->request->getPost('nama_lengkap');
        $hp       = $this->request->getPost('no_hp');
        $username = $this->request->getPost('username');
        $role     = $this->request->getPost('role');
        $pass     = $this->request->getPost('password');
        $passConf = $this->request->getPost('password_confirm');

        // 1. Validasi Password
        if ($pass != $passConf) {
            return redirect()->back()->with('error', 'Password konfirmasi tidak cocok!');
        }

        // 2. Cek Username Kembar
        if ($userModel->where('username', $username)->first()) {
            return redirect()->back()->with('error', 'Username sudah dipakai!');
        }

        // 3. Mulai Transaksi Database (Biar aman)
        $db = \Config\Database::connect();
        $db->transStart();

        // A. Simpan ke Tabel USERS (Akun Login)
        $userModel->save([
            'username' => $username,
            'password' => password_hash($pass, PASSWORD_DEFAULT),
            'role'     => $role
        ]);

        // B. Simpan ke Tabel EMPLOYEES (Data Diri)
        // Kita sesuaikan 'posisi' di employee dengan 'role' yang dipilih
        $posisi = 'Staff';
        if($role == 'kasir') $posisi = 'Kasir';
        if($role == 'sales') $posisi = 'Sales';
        if($role == 'staff_gudang') $posisi = 'Staff Gudang';

        $employeeModel->save([
            'nama_lengkap' => $nama,
            'posisi'       => $posisi,
            'no_hp'        => $hp,
            'gaji_pokok'   => 0, // Default 0, nanti diedit admin
            'tunjangan'    => 0
        ]);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Gagal mendaftar, terjadi kesalahan sistem.');
        }

        return redirect()->to('/login')->with('success', 'Registrasi Berhasil! Silakan Login.');
    }

    public function fix_password()
    {
        $db = \Config\Database::connect();
        // Hash baru yang 100% valid digenerate oleh laptopmu sendiri
        $newHash = password_hash('password123', PASSWORD_DEFAULT);

        // Update SEMUA user jadi password123
        $db->query("UPDATE users SET password = '$newHash'");

        return "Semua password telah direset menjadi: <b>password123</b>. Silakan coba login lagi.";
    }
}