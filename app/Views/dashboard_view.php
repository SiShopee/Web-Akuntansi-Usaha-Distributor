<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Web Akuntansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { display: flex; min-height: 100vh; overflow-x: hidden; }
        #sidebar { min-width: 250px; max-width: 250px; background: #343a40; color: #fff; transition: all 0.3s; }
        #sidebar .nav-link { color: #cfd8dc; margin-bottom: 5px; }
        #sidebar .nav-link:hover, #sidebar .nav-link.active { color: #fff; background: #495057; border-radius: 5px; }
        #sidebar .nav-link i { width: 25px; }
        #content { width: 100%; padding: 20px; background: #f8f9fa; }
        .card-box { border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <nav id="sidebar" class="p-3">
        <div class="sidebar-header pb-3 border-bottom mb-3">
            <h4 class="fw-bold"><i class="fa-solid fa-calculator"></i> SI-Akuntan</h4>
            <small class="text-muted">Halo, <?= session()->get('username'); ?></small>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center px-3">
                    <div class="info">
                        <a href="#" class="d-block text-white">Halo, <?= session()->get('username') ?></a>
                        <small class="text-muted text-uppercase"><?= str_replace('_', ' ', session()->get('role')) ?></small>
                    </div>
                </div>
            </li>
            
            <li class="nav-item">
                <a href="<?= base_url('dashboard') ?>" class="nav-link text-white">
                    <i class="fa-solid fa-gauge me-2"></i> Dashboard
                </a>
            </li>

            <?php if(session()->get('role') == 'pemilik' || session()->get('role') == 'staff_gudang'): ?>
            <li class="nav-item mt-3 text-muted text-uppercase small px-3">LOGISTIK</li>
            <li class="nav-item">
                <a href="<?= base_url('produk') ?>" class="nav-link text-white">
                    <i class="fa-solid fa-box me-2"></i> Data Barang
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('riwayat') ?>" class="nav-link text-white">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Stok
                </a>
            </li>
            <?php endif; ?>

            <?php if(session()->get('role') == 'pemilik' || session()->get('role') == 'kasir'): ?>
            <li class="nav-item mt-3 text-muted text-uppercase small px-3">PENJUALAN</li>
            <li class="nav-item">
                <a href="<?= base_url('transaksi') ?>" class="nav-link text-white">
                    <i class="fa-solid fa-cart-shopping me-2"></i> Kasir / Transaksi
                </a>
            </li>
            <?php endif; ?>

            <?php if(session()->get('role') == 'pemilik'): ?>
            <li class="nav-item mt-3 text-muted text-uppercase small px-3">HR & KARYAWAN</li>
            <li class="nav-item">
                <a href="<?= base_url('karyawan') ?>" class="nav-link text-white">
                    <i class="fa-solid fa-users me-2"></i> Data Karyawan
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('absensi') ?>" class="nav-link text-white">
                    <i class="fa-solid fa-clock me-2"></i> Absensi
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('gaji') ?>" class="nav-link text-white">
                    <i class="fa-solid fa-money-bill-wave me-2"></i> Penggajian
                </a>
            </li>
            <?php endif; ?>

            <?php if(session()->get('role') == 'pemilik' || session()->get('role') == 'sales'): ?>
            <li class="nav-item mt-3 text-muted text-uppercase small px-3">LAPORAN</li>
            <li class="nav-item">
                <a href="<?= base_url('laporan') ?>" class="nav-link text-white">
                    <i class="fa-solid fa-chart-line me-2"></i> Laporan Keuangan
                </a>
            </li>
            <?php endif; ?>

            <li class="nav-item mt-4">
                <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <div id="content">
        <nav class="navbar navbar-light bg-white mb-4 shadow-sm rounded">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Dashboard Overview</span>
            </div>
        </nav>

<?= $this->renderSection('content') ?>

</body>
</html>