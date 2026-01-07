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
        $validation = \Config\Services::validation();
        $userModel = new \App\Models\UserModel();
        $employeeModel = new \App\Models\EmployeeModel(); // Panggil Model Karyawan

        // --- 1. VALIDASI (Sama seperti sebelumnya) ---
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[4]',
            'password_confirm' => 'matches[password]',
            'role' => 'required'
        ];

        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
            $firstError = array_values($errors)[0]; 
            return redirect()->back()->withInput()->with('error', $firstError);
        }

        // --- 2. SIMPAN KE TABEL USERS (Buat Akun Login) ---
        $username = $this->request->getVar('username');
        $role     = $this->request->getVar('role');

        $userData = [
            'username'     => $username,
            'password'     => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'         => $role,
            'nama_lengkap' => $username, // Pakai username sebagai nama awal
            'foto'         => 'default.png'
        ];
        
        $userModel->insert($userData);

        // --- 3. OTOMATIS SIMPAN KE TABEL EMPLOYEES (Buat Data Gaji) ---
        // Karena dia daftar sendiri, Gaji & No HP kita isi default dulu (0 dan -)
        // Nanti Admin yang harus edit gajinya.
        
        // Mapping Role ke Posisi yang rapi
        $posisiNama = ucwords(str_replace('_', ' ', $role)); // misal: staff_gudang -> Staff Gudang

        $empData = [
            'nama_lengkap' => $username, // Samakan dengan user
            'posisi'       => $posisiNama,
            'gaji_pokok'   => 0,   // Default 0
            'tunjangan'    => 0,   // Default 0
            'no_hp'        => '-'  // Default strip
        ];

        $employeeModel->insert($empData);

        return redirect()->to('/login')->with('success', 'Akun berhasil dibuat & Data Karyawan terdaftar!');
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