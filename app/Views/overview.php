<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-4">Dashboard Overview</h3>

    <?php if($user_role == 'kasir'): ?>
        <div class="alert alert-info">
            <h4><i class="fa-solid fa-cash-register"></i> Halo, <?= session()->get('username') ?>!</h4>
            <p>Selamat bertugas! Fokus pada pelayanan pelanggan yang ramah dan cepat.</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow h-100 py-4 border-left-primary">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-cart-plus fa-4x text-primary mb-3"></i>
                        <h3>Transaksi Baru</h3>
                        <p>Layani pelanggan baru sekarang</p>
                        <a href="<?= base_url('transaksi') ?>" class="btn btn-primary btn-lg px-5">Buka Mesin Kasir</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow h-100 py-4">
                    <div class="card-body">
                        <h5 class="font-weight-bold">Status Hari Ini</h5>
                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item d-flex justify-content-between">
                                Tanggal <span class="fw-bold"><?= date('d F Y') ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Jam Login <span class="badge bg-success">Sekarang</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Penjualan Toko <span class="fw-bold text-primary">Rp <?= number_format($total_penjualan) ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif($user_role == 'staff_gudang'): ?>
        <div class="alert alert-warning">
            <h4><i class="fa-solid fa-warehouse"></i> Halo, Tim Gudang!</h4>
            <p>Pastikan stok barang selalu aman. Cek riwayat barang masuk dan keluar secara berkala.</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white shadow h-100 py-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Jenis Produk</div>
                                <div class="h5 mb-0 font-weight-bold"><?= $total_produk ?> Jenis Barang</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-boxes-stacked fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                    </div>
                    <div class="card-body">
                        <a href="<?= base_url('produk') ?>" class="btn btn-success btn-icon-split mb-2">
                            <span class="icon text-white-50"><i class="fa-solid fa-plus"></i></span>
                            <span class="text">Restock Barang</span>
                        </a>
                        <a href="<?= base_url('riwayat') ?>" class="btn btn-info btn-icon-split mb-2">
                            <span class="icon text-white-50"><i class="fa-solid fa-list"></i></span>
                            <span class="text">Lihat Riwayat Keluar/Masuk</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

  <?php else: ?>
        <?php if($user_role == 'sales'): ?>
            <div class="alert alert-success mb-4">
                <h4><i class="fa-solid fa-chart-line"></i> Halo, Tim Sales!</h4>
                <p>Pantau terus performa penjualan kita hari ini. Semangat kejar target!</p>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card card-box p-3 bg-primary text-white">
                    <h5>Total Penjualan</h5>
                    <h3>Rp <?= number_format($total_penjualan, 0, ',', '.') ?></h3>
                    <small>Omzet Kotor</small>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-box p-3 bg-success text-white">
                    <h5>Laba Bersih</h5>
                    <h3>Rp <?= number_format($laba_bersih, 0, ',', '.') ?></h3>
                    <small>Keuntungan Perusahaan</small>
                </div>
            </div>

            <?php if($user_role == 'pemilik'): ?>
            <div class="col-md-4 mb-3">
                <div class="card card-box p-3 bg-warning text-dark">
                    <h5>Jumlah Karyawan</h5>
                    <h3><?= $total_karyawan ?> Orang</h3>
                    <small>Total Tim</small>
                </div>
            </div>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>