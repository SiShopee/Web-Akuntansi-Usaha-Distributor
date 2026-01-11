<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Arus Barang</h1>
    <a href="<?= base_url('produk') ?>" class="btn btn-secondary btn-sm">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Barang
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Log Transaksi Stok</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Arah</th>
                        <th>Jml</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Kita cek: Apakah variabel $riwayat ada isinya?
                    if (!empty($riwayat) && is_array($riwayat)) : 
                        $no = 1; 
                        foreach($riwayat as $r): 
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d M Y H:i', strtotime($r['created_at'])) ?></td>
                        
                        <td><?= $r['kode_barang'] ?? '-' ?></td>
                        
                        <td>
                            <?php if(!empty($r['nama_barang'])): ?>
                                <b><?= $r['nama_barang'] ?></b>
                            <?php else: ?>
                                <span class="text-danger small fst-italic">
                                    (Barang #<?= $r['product_id'] ?> Terhapus)
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if($r['type'] == 'masuk'): ?>
                                <span class="badge bg-success rounded-pill">
                                    <i class="fa-solid fa-arrow-down"></i> Masuk
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger rounded-pill">
                                    <i class="fa-solid fa-arrow-up"></i> Keluar
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="fw-bold text-center"><?= $r['qty'] ?></td>
                        
                        <td><?= $r['keterangan'] ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    
                    <tr>
                        <td colspan="7" class="text-center p-5 text-muted">
                            <i class="fa-solid fa-box-open fa-3x mb-3"></i><br>
                            Belum ada riwayat transaksi stok.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
