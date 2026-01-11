<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Barang Dagangan</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fa-solid fa-plus"></i> Tambah Barang Baru
    </button>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    foreach($products as $p): 
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p['kode_barang'] ?? '-' ?></td>
                        <td><?= $p['nama_barang'] ?></td>
                        <td>Rp <?= number_format($p['harga_beli'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($p['harga_jual'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge bg-<?= $p['stok'] > 0 ? 'success' : 'danger' ?>">
                                <?= $p['stok'] ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalStok<?= $p['id'] ?>" title="Tambah Stok">
                                <i class="fa-solid fa-plus"></i>
                            </button>

                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $p['id'] ?>" title="Edit Info Barang">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($products as $p): ?>

    <div class="modal fade" id="modalStok<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Tambah Stok: <?= $p['nama_barang'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('riwayat/add_stok') ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">

                        <div class="mb-3">
                            <label class="fw-bold">Jumlah Masuk</label>
                            <input type="number" name="qty" class="form-control" placeholder="Contoh: 10" required min="1">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Keterangan (Wajib)</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Kulakan dari Supplier A" required></textarea>
                        </div>
                        
                        <div class="alert alert-info small mb-0">
                            <i class="fa-solid fa-info-circle"></i> Stok saat ini: <strong><?= $p['stok'] ?></strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan Stok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold">Edit Barang: <?= $p['nama_barang'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('produk/update/' . $p['id']) ?>" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-bold">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" value="<?= $p['nama_barang'] ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Harga Beli</label>
                                <input type="number" name="harga_beli" class="form-control" value="<?= $p['harga_beli'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Harga Jual</label>
                                <input type="number" name="harga_jual" class="form-control" value="<?= $p['harga_jual'] ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Stok tidak bisa diedit disini. Gunakan tombol Tambah Stok.</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fa-solid fa-box"></i> Tambah Barang Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('produk/store') ?>" method="post">
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label class="fw-bold">Kode Barang (Unik)</label>
                        <input type="text" name="kode_barang" class="form-control" placeholder="Contoh: LP001" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Laptop Gaming" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Harga Beli (Modal)</label>
                            <input type="number" name="harga_beli" class="form-control" placeholder="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Stok Awal</label>
                        <input type="number" name="stok" class="form-control" placeholder="0" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
