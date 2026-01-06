<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Riwayat Kehadiran</h3>
        <a href="<?= base_url('absensi/create') ?>" class="btn btn-primary">
            <i class="fa-solid fa-calendar-check"></i> Input Absensi
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Karyawan</th>
                        <th>Posisi</th>
                        <th>Status</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($attendance as $a): ?>
                    <tr>
                        <td><?= date('d M Y', strtotime($a['tanggal'])) ?></td>
                        <td class="fw-bold"><?= $a['nama_lengkap'] ?></td>
                        <td><?= $a['posisi'] ?></td>
                        <td>
                            <?php 
                                $badge = 'secondary';
                                if($a['status'] == 'hadir') $badge = 'success';
                                if($a['status'] == 'sakit') $badge = 'warning';
                                if($a['status'] == 'alpa') $badge = 'danger';
                            ?>
                            <span class="badge bg-<?= $badge ?>"><?= strtoupper($a['status']) ?></span>
                        </td>
                        <td><?= $a['jam_masuk'] ?></td>
                        <td><?= $a['jam_keluar'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>