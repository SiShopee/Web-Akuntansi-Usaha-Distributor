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

        // 1. ATURAN VALIDASI (Versi Perbaikan: Pakai Kurung Siku [])
        $rules = [
            'username' => [
                'rules'  => 'required|min_length[3]|is_unique[users.username]', // <--- PERBAIKAN DI SINI
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'is_unique' => 'Username sudah terpakai! Ganti yang lain.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[4]', // <--- PERBAIKAN DI SINI
                'errors' => [
                    'min_length' => 'Password minimal 4 karakter.'
                ]
            ],
            'password_confirm' => [
                'rules'  => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi Password tidak cocok!'
                ]
            ],
            'role' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Jabatan belum dipilih.'
                ]
            ]
        ];

        // 2. JALANKAN VALIDASI
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
            $firstError = array_values($errors)[0]; 
            return redirect()->back()->withInput()->with('error', $firstError);
        }

        // 3. SIAPKAN DATA
        $data = [
            'username'     => $this->request->getVar('username'),
            'password'     => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'         => $this->request->getVar('role'),
            'nama_lengkap' => $this->request->getVar('username'),
            'foto'         => 'default.png'
        ];

        // 4. SIMPAN
        if ($userModel->insert($data)) {
            return redirect()->to('/login')->with('success', 'Akun berhasil dibuat! Silakan Login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan ke database.');
        }
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