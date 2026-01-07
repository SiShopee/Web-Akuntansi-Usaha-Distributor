<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Riwayat Arus Barang</h3>
        <button class="btn btn-secondary btn-sm" onclick="window.print()">
            <i class="fa-solid fa-print"></i> Cetak Log
        </button>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Waktu Kejadian</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Arah</th>
                            <th class="text-center">Qty</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($history)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat transaksi.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no=1; foreach($history as $h): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <?= date('d/m/Y H:i', strtotime($h['created_at'])) ?>
                                </td>
                                <td><?= $h['kode_barang'] ?></td>
                                <td class="fw-bold"><?= $h['nama_barang'] ?></td>
                                <td class="text-center">
                                    <?php if($h['type'] == 'masuk'): ?>
                                        <span class="badge bg-success rounded-pill px-3">
                                            <i class="fa-solid fa-arrow-down"></i> MASUK
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger rounded-pill px-3">
                                            <i class="fa-solid fa-arrow-up"></i> KELUAR
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center fw-bold fs-5"><?= $h['qty'] ?></td>
                                <td class="text-muted small"><?= $h['keterangan'] ?></td>
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