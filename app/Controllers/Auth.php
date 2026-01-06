<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('login_view'); // Kita akan buat view ini di Langkah 2
    }

    public function process_login()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // 1. Cari user berdasarkan username
        $user = $model->where('username', $username)->first();

        if ($user) {
            // 2. Cek password (pakai verify karena tadi di-hash)
            if (password_verify($password, $user['password'])) {
                // 3. Simpan data user ke sesi (Session)
                $session_data = [
                    'id'        => $user['id'],
                    'username'  => $user['username'],
                    'role'      => $user['role'],
                    'isLoggedIn'=> true
                ];
                session()->set($session_data);
                
                return redirect()->to('/dashboard');
            }
        }

        // Jika gagal
        return redirect()->back()->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // Fungsi darurat untuk reset password admin
    public function reset_admin()
    {
        $model = new \App\Models\UserModel();

        // Kita buat hash baru langsung dari sistem laptopmu
        $passwordBaru = password_hash('password123', PASSWORD_DEFAULT);

        // Update user admin
        $model->where('username', 'admin')
            ->set(['password' => $passwordBaru])
            ->update();

        return "Password Admin BERHASIL di-reset menjadi: <b>password123</b>. Silakan coba login lagi.";
    }
}