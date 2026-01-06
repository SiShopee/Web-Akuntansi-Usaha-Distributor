<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Laporan Penggajian</h3>
        <a href="<?= base_url('gaji/create') ?>" class="btn btn-success">
            <i class="fa-solid fa-calculator"></i> Hitung Gaji Baru
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Bulan</th>
                        <th>Nama Karyawan</th>
                        <th>Posisi</th>
                        <th>Hadir</th>
                        <th>Potongan</th>
                        <th>Total Gaji Bersih</th>
                        <th>Tanggal Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($payroll as $p): ?>
                    <tr>
                        <td><?= $p['bulan_tahun'] ?></td>
                        <td class="fw-bold"><?= $p['nama_lengkap'] ?></td>
                        <td><?= $p['posisi'] ?></td>
                        <td><?= $p['total_hadir'] ?> Hari</td>
                        <td class="text-danger">Rp <?= number_format($p['potongan'], 0, ',', '.') ?></td>
                        <td class="text-success fw-bold">Rp <?= number_format($p['total_gaji_bersih'], 0, ',', '.') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($p['tanggal_generate'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>