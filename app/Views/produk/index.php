<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?> <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Barang Dagangan</h3>
        <a href="<?= base_url('produk/create') ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Barang
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($products as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $p['kode_barang'] ?></td>
                            <td><?= $p['nama_barang'] ?></td>
                            <td>Rp <?= number_format($p['harga_beli'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($p['harga_jual'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge bg-<?= $p['stok'] < 5 ? 'danger' : 'success' ?>">
                                    <?= $p['stok'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('produk/delete/'.$p['id']) ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin mau dihapus?')">
                                   <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>