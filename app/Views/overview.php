<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-4">
        <div class="card card-box p-3 bg-primary text-white">
            <h5>Total Penjualan</h5>
            <h3>Rp 0</h3>
            <small>Hari ini</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-box p-3 bg-success text-white">
            <h5>Laba Bersih</h5>
            <h3>Rp 0</h3>
            <small>Bulan ini</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-box p-3 bg-warning text-dark">
            <h5>Jumlah Karyawan</h5>
            <h3>0 Orang</h3>
            <small>Aktif</small>
        </div>
    </div>
</div>

<div class="mt-5 text-center text-muted">
    <p>Selamat datang di Sistem Akuntansi Distributor.</p>
    <p>Silakan pilih menu di samping untuk mulai bekerja.</p>
</div>

<?= $this->endSection() ?>