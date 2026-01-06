<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Cek apakah user sudah login? Kalau belum, tendang ke login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Dashboard Utama',
            'user_role' => session()->get('role') // Kita kirim role (pemilik/karyawan) ke view
        ];

        return view('overview', $data);
    }
}