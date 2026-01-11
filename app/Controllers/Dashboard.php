<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // 1. Cek Login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // --- A. DETEKSI KOLOM (Untuk Tabel Lain) ---
        $kolomQty  = $db->fieldExists('quantity', 'sale_items') ? 'quantity' : 'qty';
        $kolomNama = $db->fieldExists('nama_barang', 'products') ? 'nama_barang' : 'nama_produk';

        // --- B. DATA KARTU ATAS (Omzet, Laba, Karyawan) ---
        
        // 1. Omzet Real (Kita hitung ulang dari rincian barang biar akurat)
        $queryOmzet = $db->query("
            SELECT SUM(products.harga_jual * sale_items.$kolomQty) as total_omzet 
            FROM sale_items 
            JOIN products ON sale_items.product_id = products.id
        ");
        $omzet = $queryOmzet->getRow()->total_omzet ?? 0;

        // 2. Modal
        $queryModal = $db->query("
            SELECT SUM(products.harga_beli * sale_items.$kolomQty) as total_modal 
            FROM sale_items 
            JOIN products ON sale_items.product_id = products.id
        ");
        $modal = $queryModal->getRow()->total_modal ?? 0;

        // 3. Gaji
        $queryGaji = $db->query("SELECT SUM(total_gaji_bersih) as total FROM payroll");
        $gaji = $queryGaji->getRow()->total ?? 0;

        // 4. Hitung Laba & Total Karyawan
        $laba_bersih    = $omzet - $modal - $gaji;
        $total_karyawan = $db->table('employees')->countAllResults();

	// CEK STATUS ABSENSI USER 
        $attModel = new \App\Models\AttendanceModel();
        $today    = date('Y-m-d');
        $userId   = session()->get('id');

	
	$sudahAbsen = $attModel->where('user_id', $userId)
                               ->where('tanggal', $today)
                               ->first();

        // --- C. DATA GRAFIK & TABEL (PERBAIKAN UTAMA DISINI) ---

        // 1. GRAFIK: Penjualan 7 Hari Terakhir
        // Perbaikan: Pakai kolom 'tanggal' dan 'grand_total' sesuai screenshot
        $queryChart = $db->query("
            SELECT DATE(tanggal) as tgl, SUM(grand_total) as total
            FROM sales
            GROUP BY DATE(tanggal)
            ORDER BY tgl DESC
            LIMIT 7
        ");
        $chartData = $queryChart->getResultArray();

        // 2. STOK MENIPIS (Limit < 10)
        $stokMenipis = $db->table('products')
                          ->where('stok <', 10)
                          ->orderBy('stok', 'ASC')
                          ->limit(5)
                          ->get()->getResultArray();

	// 3. TRANSAKSI TERBESAR (Top 5 Berdasarkan Uang)
        // Perbaikan: Order by grand_total DESC (Uang Terbanyak)
        // Kita gunakan query builder agar lebih rapi handling tabel users-nya
        $transaksiTerbaru = $db->query("
            SELECT sales.*, users.username as kasir
            FROM sales
            LEFT JOIN users ON sales.user_id = users.id
            ORDER BY sales.grand_total DESC
            LIMIT 5
        ")->getResultArray();

        // --- D. DATA PESAN MASUK (INBOX) ---
        // Ambil pesan yang ditujukan untuk Role yang sedang login
        $roleSaya = session()->get('role');
	$messageModel = new \App\Models\MessageModel();
	$pesanMasuk = $messageModel->where('target_role', $roleSaya)
                                   ->where('is_read', 0)
                                   ->orderBy('created_at', 'DESC')
                                   ->findAll();        
            $data = [
            'title' => 'Dashboard Utama',
            'user_role' => session()->get('role'),
            
            // Data Kartu
            'total_penjualan' => $omzet,
            'laba_bersih'     => $laba_bersih,
            'total_karyawan'  => $total_karyawan,
            
            // Data Grafik & Tabel
            'chart_data'      => array_reverse($chartData),
            'stok_menipis'    => $stokMenipis,
            'transaksi_baru'  => $transaksiTerbaru,
            
            // DATA Inbox Pesan
            'pesan_masuk'     => $pesanMasuk,
             
	    // KIRIM STATUS ABSEN KE VIEW
            'sudah_absen'     => $sudahAbsen ? true : false,
            'jam_absen'       => $sudahAbsen ? $sudahAbsen['jam_masuk'] : '-'
   
	];

        return view('overview', $data);
    }

    public function absen_masuk()
    {
        if (!session()->get('isLoggedIn')) { return redirect()->to('/login'); }

        $attModel = new \App\Models\AttendanceModel();
        $userId   = session()->get('id');
        $today    = date('Y-m-d');

        // Cek apakah sudah absen hari ini? (Double Check)
        $cek = $attModel->where('user_id', $userId)->where('tanggal', $today)->first();
        
        if ($cek) {
            return redirect()->to('/dashboard')->with('error', 'Anda sudah absen hari ini!');
        }

        // Simpan Absensi
        $attModel->save([
            'user_id'       => $userId,
            'nama_karyawan' => session()->get('nama_lengkap') ?? session()->get('username'), // Fallback ke username kalau nama null
            'tanggal'       => $today,
            'jam_masuk'     => date('H:i:s'),
            'status'        => 'Hadir'
        ]);

        return redirect()->to('/dashboard')->with('success', 'Berhasil Absen! Selamat bekerja.');
    }

}
