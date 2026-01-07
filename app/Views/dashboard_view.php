<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - SI Akuntan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- 1. PALET WARNA BARU (Lembut & Profesional) --- */
        :root {
            --primary-color: #2c3e50;    /* Biru Dongker (Menu/Sidebar) */
            --accent-color: #3498db;     /* Biru Langit (Tombol/Link) */
            --success-color: #27ae60;    /* Hijau Kalem (Uang/Berhasil) */
            --warning-color: #f39c12;    /* Oranye (Peringatan) */
            --danger-color: #e74a3b;     /* Merah Soft (Hapus/Error) */
            --bg-body: #f3f4f6;          /* Abu-abu sangat muda (Background) */
            --text-dark: #2d3436;        /* Hitam tidak pekat (Tulisan) */
        }

        body { 
            font-family: 'Nunito', sans-serif; 
            background-color: var(--bg-body); 
            color: var(--text-dark);
        }
        
        /* --- 2. SIDEBAR ELEGANT (Versi High Contrast) --- */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1e272e 0%, #2c3e50 100%);
            color: #fff;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            z-index: 100;
        }

        /* Menu Link Biasa - Dibuat Putih Terang */
        #sidebar .nav-link { 
            color: #ffffff;          /* Putih Mutlak */
            font-weight: 500;        /* Agak tebal sedikit biar jelas */
            padding: 14px 25px; 
            font-size: 0.95rem;
            border-left: 4px solid transparent; 
            transition: all 0.3s;
            opacity: 0.9;            /* Sedikit transparansi biar tidak menusuk, tapi tetap terang */
        }

        /* Judul Kategori Kecil (Logistik, Penjualan, dll) */
        /* Sebelumnya ini gelap banget, sekarang kita terangkan */
        #sidebar .text-muted {
            color: #bdc3c7 !important; /* Abu-abu Terang (Silver) */
            font-weight: bold;
            letter-spacing: 1px;       /* Jarak antar huruf biar lega */
            opacity: 1 !important;
        }

        /* Efek Hover (Saat mouse nempel) */
        #sidebar .nav-link:hover { 
            color: #fff; 
            background-color: rgba(255,255,255,0.1); /* Background putih transparan */
            border-left: 4px solid #3498db;          /* Garis Biru */
            padding-left: 30px; 
            opacity: 1;
        }

        /* Menu yang Sedang Aktif (Halaman yang dibuka) */
        #sidebar .nav-link.active { 
            color: #ffeaa7;          /* Warna Emas Muda (Biar beda dengan yang lain) */
            background: rgba(255, 255, 255, 0.15); 
            border-left: 4px solid #f1c40f; /* Garis Emas */
            font-weight: bold;
            opacity: 1;
        }
        
        /* Ikon di dalam menu */
        #sidebar .nav-link i {
            width: 25px;            /* Lebar ikon tetap agar teks rata */
            text-align: center;
        }
        
        /* --- 3. NAVBAR PUTIH BERSIH --- */
        .navbar { 
            background: white !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04); 
            height: 70px;
        }
        
        /* --- 4. KARTU (CARD) MODERN --- */
        .card { 
            border: none; /* Hilangkan garis pinggir kasar */
            border-radius: 12px; /* Sudut tumpul */
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); /* Bayangan halus */
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-3px); /* Efek naik dikit pas di-hover */
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #f0f0f0;
            font-weight: bold;
            color: var(--primary-color);
            border-radius: 12px 12px 0 0 !important;
        }

        /* --- 5. TOMBOL-TOMBOL --- */
        .btn-primary { 
            background-color: var(--accent-color); 
            border: none;
            box-shadow: 0 4px 6px rgba(52, 152, 219, 0.3);
        }
        .btn-primary:hover { background-color: #2980b9; }

        .btn-success { 
            background-color: var(--success-color); 
            border: none; 
            box-shadow: 0 4px 6px rgba(39, 174, 96, 0.3);
        }

        .btn-danger { 
            background-color: var(--danger-color); 
            border: none; 
        }

        /* Foto Profil */
        .img-profile { 
            height: 40px; width: 40px; 
            object-fit: cover; 
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* --- PERBAIKAN LEBAR KONTEN --- */
        #content {
            flex: 1;              /* Perintah agar mengambil SISA ruang kosong */
            width: 0;             /* Trik agar tidak bocor ke samping */
            display: flex;
            flex-direction: column;
            overflow-x: hidden;   /* Hilangkan scrollbar samping jika ada */
        }
    </style>
</head>

<body class="d-flex">

    <nav id="sidebar">
        <div class="sidebar-brand p-4 text-center mb-2">
            <div class="sidebar-brand-icon rotate-n-15 mb-2">
                <i class="fa-solid fa-chart-pie fa-2x text-warning"></i>
            </div>
            <h5 class="fw-bold text-white tracking-wide">SI-AKUNTAN</h5>
            <div class="text-xs text-white-50 font-italic">Sistem Manajemen Bisnis</div>
        </div>
        <hr class="sidebar-divider my-0 border-light opacity-25 mb-3">
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="<?= base_url('dashboard') ?>" class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>">
                    <i class="fa-solid fa-gauge me-2"></i> Dashboard
                </a>
            </li>

            <?php if(session()->get('role') == 'pemilik' || session()->get('role') == 'staff_gudang'): ?>
            <li class="nav-item mt-3 text-uppercase small text-muted px-3">Logistik</li>
            <li class="nav-item">
                <a href="<?= base_url('produk') ?>" class="nav-link <?= uri_string() == 'produk' ? 'active' : '' ?>">
                    <i class="fa-solid fa-box me-2"></i> Data Barang
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('riwayat') ?>" class="nav-link <?= uri_string() == 'riwayat' ? 'active' : '' ?>">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Stok
                </a>
            </li>
            <?php endif; ?>

            <?php if(session()->get('role') == 'pemilik' || session()->get('role') == 'kasir'): ?>
            <li class="nav-item mt-3 text-uppercase small text-muted px-3">Penjualan</li>
            <li class="nav-item">
                <a href="<?= base_url('transaksi') ?>" class="nav-link <?= uri_string() == 'transaksi' ? 'active' : '' ?>">
                    <i class="fa-solid fa-cart-shopping me-2"></i> Kasir / Transaksi
                </a>
            </li>
            <?php endif; ?>

            <?php if(session()->get('role') == 'pemilik'): ?>
            <li class="nav-item mt-3 text-uppercase small text-muted px-3">HR & Karyawan</li>
            <li class="nav-item">
                <a href="<?= base_url('karyawan') ?>" class="nav-link <?= uri_string() == 'karyawan' ? 'active' : '' ?>">
                    <i class="fa-solid fa-users me-2"></i> Data Karyawan
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('absensi') ?>" class="nav-link <?= uri_string() == 'absensi' ? 'active' : '' ?>">
                    <i class="fa-solid fa-clock me-2"></i> Absensi
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('gaji') ?>" class="nav-link <?= uri_string() == 'gaji' ? 'active' : '' ?>">
                    <i class="fa-solid fa-money-bill-wave me-2"></i> Penggajian
                </a>
            </li>
            <?php endif; ?>

            <?php if(session()->get('role') == 'pemilik' || session()->get('role') == 'sales'): ?>
            <li class="nav-item mt-3 text-uppercase small text-muted px-3">Laporan</li>
            <li class="nav-item">
                <a href="<?= base_url('laporan') ?>" class="nav-link <?= uri_string() == 'laporan' ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-line me-2"></i> Laporan Keuangan
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>

    <div id="content">
        
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top px-4">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <ul class="navbar-nav ms-auto">
                
                <div class="topbar-divider d-none d-sm-block" style="width: 1px; background-color: #e3e6f0; margin: 0 1rem;"></div>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text-end me-2 d-none d-lg-block">
                            <span class="text-gray-600 small fw-bold d-block">
                                <?= session()->get('nama_lengkap') ? session()->get('nama_lengkap') : session()->get('username') ?>
                            </span>
                            <span class="text-muted small" style="font-size: 10px;">
                                <?= strtoupper(str_replace('_', ' ', session()->get('role'))) ?>
                            </span>
                        </div>
                        
                        <?php 
                            $userModel = new \App\Models\UserModel();
                            $user = $userModel->find(session()->get('id'));
                            $foto = $user['foto'] ?? 'default.png';
                        ?>
                        <img class="img-profile rounded-circle border" 
                             src="<?= base_url('uploads/' . $foto) ?>"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?= session()->get('username') ?>&background=random'">
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('profil') ?>">
                                <i class="fa-solid fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Edit Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                <i class="fa-solid fa-right-from-bracket fa-sm fa-fw mr-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="px-4">
            <?= $this->renderSection('content') ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        setTimeout(function() {
            let alert = document.querySelector('.alert');
            if(alert) alert.style.display = 'none';
        }, 3000);
    </script>
</body>
</html>