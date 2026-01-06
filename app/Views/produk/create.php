<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h3>Tambah Barang Baru</h3>
    
    <div class="card shadow mt-3 col-md-8">
        <div class="card-body">
            <form action="<?= base_url('produk/store') ?>" method="post">
                <div class="mb-3">
                    <label>Kode Barang (Barcode)</label>
                    <input type="text" name="kode_barang" class="form-control" placeholder="Contoh: BRG001" required>
                </div>
                <div class="mb-3">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Harga Beli (Modal)</label>
                        <input type="number" name="harga_beli" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Harga Jual</label>
                        <input type="number" name="harga_jual" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Stok Awal</label>
                    <input type="number" name="stok" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="<?= base_url('produk') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>