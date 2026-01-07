<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="row">
        <div class="col-md-4">
            <div class="card card-box p-3 bg-primary text-white">
                <h5>Total Penjualan</h5>
                <h3>Rp <?= number_format($total_penjualan, 0, ',', '.') ?></h3>
                <small>Total Keseluruhan</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box p-3 bg-<?= $laba_bersih >= 0 ? 'success' : 'danger' ?> text-white">
                <h5>Laba Bersih</h5>
                <h3>Rp <?= number_format($laba_bersih, 0, ',', '.') ?></h3>
                <small>Status: <?= $laba_bersih >= 0 ? 'Profit' : 'Loss' ?></small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box p-3 bg-warning text-dark">
                <h5>Jumlah Karyawan</h5>
                <h3><?= $total_karyawan ?> Orang</h3>
                <small>Data Terdaftar</small>
            </div>
        </div>
    </div>

<div class="mt-5 text-center text-muted">
    <p>Selamat datang di Sistem Akuntansi Distributor.</p>
    <p>Silakan pilih menu di samping untuk mulai bekerja.</p>
</div>

<?= $this->endSection() ?>