<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $id = session()->get('id');
        
        $data = [
            'title' => 'Edit Profil Saya',
            'user'  => $model->find($id),
            'user_role' => session()->get('role')
        ];

        return view('profil_view', $data);
    }

    public function update()
    {
        $model = new \App\Models\UserModel();
        $id = session()->get('id');
        
        // 1. Ambil Data Inputan
        $data = [
            'id' => $id,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
        ];

        // 2. Cek Apakah Ada File Foto Baru?
        $fileFoto = $this->request->getFile('foto');
        
        // Validasi Ekstra: Pastikan file valid
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            
            // A. Generate Nama Baru (Acak)
            $namaFoto = $fileFoto->getRandomName();
            
            // B. PINDAHKAN KE FOLDER PUBLIC/UPLOADS (PENTING: Pakai FCPATH)
            // FCPATH mengarah ke folder 'public' di project kamu
            $fileFoto->move(FCPATH . 'uploads', $namaFoto);
            
            // C. Masukkan nama file ke array data untuk disimpan ke DB
            $data['foto'] = $namaFoto;
        }

        // 3. Cek Password
        $passwordBaru = $this->request->getPost('password');
        if (!empty($passwordBaru)) {
            $data['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        // 4. Eksekusi Simpan ke Database
        if ($model->save($data)) {
            // Update Session agar nama langsung berubah tanpa logout
            session()->set('nama_lengkap', $data['nama_lengkap']);
            return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->to('/profil')->with('error', 'Gagal menyimpan ke database.');
        }
    }
}