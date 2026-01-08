<?php

namespace App\Controllers;

use App\Models\MessageModel;

class Pesan extends BaseController
{
    public function kirim()
    {
        // 1. Cek Login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $messageModel = new \App\Models\MessageModel();

        // 2. AMBIL DATA PENGIRIM (DENGAN CADANGAN/FALLBACK)
        // Coba ambil nama lengkap dulu
        $pengirimNama = session()->get('nama_lengkap');
        
        // JIKA KOSONG, PAKAI USERNAME SAJA
        if (empty($pengirimNama)) {
            $pengirimNama = session()->get('username');
        }

        // 3. Simpan ke Database
        $messageModel->save([
            'sender_id'   => session()->get('id'),
            'sender_name' => $pengirimNama, // Sekarang pasti terisi (tidak mungkin null)
            'target_role' => $this->request->getPost('tujuan'),
            'message'     => $this->request->getPost('isi_pesan'),
            'is_read'     => 0
        ]);

        return redirect()->to('/dashboard')->with('success', 'Pesan berhasil dikirim!');
    }
}