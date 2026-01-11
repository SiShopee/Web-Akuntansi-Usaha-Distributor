<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 fw-bold">
        <i class="fa-solid fa-clipboard-user me-2"></i>Data Absensi Karyawan
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Kehadiran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Karyawan</th>
                            <th>Jam Masuk</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($attendance)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada data absensi.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($attendance as $a): ?>
                            <tr>
                                <td>
                                    <?= date('d M Y', strtotime($a['tanggal'])) ?>
                                </td>

                                <td class="fw-bold text-dark">
                                    <?= esc($a['nama_karyawan']) ?>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fa-regular fa-clock me-1"></i> <?= $a['jam_masuk'] ?>
                                    </span>
                                </td>

                                <td>
                                    <?php 
                                        $badge = 'secondary';
                                        $status = strtolower($a['status']); // Ubah ke huruf kecil biar aman
                                        if($status == 'hadir') $badge = 'success';
                                        if($status == 'sakit') $badge = 'warning';
                                        if($status == 'izin')  $badge = 'info';
                                        if($status == 'alpa')  $badge = 'danger';
                                    ?>
                                    <span class="badge bg-<?= $badge ?>">
                                        <?= strtoupper($a['status']) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
