<?= $this->extend('dashboard_view') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h3>Restock Barang: <span class="text-primary"><?= $product['nama_barang'] ?></span></h3>
    
    <div class="card shadow mt-3 col-md-6">
        <div class="card-body">
            <form action="<?= base_url('produk/process_restock') ?>" method="post">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                
                <div class="mb-3">
                    <label>Stok Saat Ini</label>
                    <input type="text" class="form-control" value="<?= $product['stok'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label>Jumlah Masuk (Qty)</label>
                    <input type="number" name="qty" class="form-control" placeholder="0" min="1" required>
                </div>

                <div class="mb-3">
                    <label>Keterangan / Sumber</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Beli dari Supplier ABC" required>
                </div>
                
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-plus-circle"></i> Tambah Stok
                </button>
                <a href="<?= base_url('produk') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>