<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="row mb-3">
    <div class="col-12">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><i class="fa-solid fa-check-circle"></i> Sukses!</strong> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fa-solid fa-triangle-exclamation"></i> Gagal!</strong> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 fw-bold"><i class="fa-solid fa-cart-plus"></i> Pilih Barang</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('transaksi/add') ?>" method="post">
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php foreach($products as $p): ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= $p['nama_barang'] ?> | Stok: <?= $p['stok'] ?> | Rp<?= number_format($p['harga_jual']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label>Jumlah (Qty)</label>
                        <input type="number" name="qty" class="form-control" value="1" min="1" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa-solid fa-plus"></i> Masukkan ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header py-3 bg-dark text-white d-flex justify-content-between">
                <h6 class="m-0 fw-bold"><i class="fa-solid fa-list"></i> Keranjang Belanja</h6>
                <a href="<?= base_url('transaksi/clear') ?>" class="btn btn-danger btn-sm">Reset</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_total = 0;
                        if (!empty($cart)): 
                            foreach($cart as $item): 
                                $subtotal = $item['price'] * $item['qty'];
                                $grand_total += $subtotal;
                        ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td>Rp <?= number_format($item['price']) ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td class="text-end fw-bold">Rp <?= number_format($subtotal) ?></td>
                        </tr>
                        <?php endforeach; endif; ?>
                        
                        <tr class="table-warning">
                            <td colspan="3" class="fw-bold text-center">TOTAL BAYAR</td>
                            <td class="fw-bold text-end fs-5">Rp <?= number_format($grand_total) ?></td>
                        </tr>
                    </tbody>
                </table>

                <form action="<?= base_url('transaksi/process_payment') ?>" method="post">
                    <button type="submit" class="btn btn-primary w-100 p-3 mt-3" <?= empty($cart) ? 'disabled' : '' ?>>
                        <i class="fa-solid fa-money-bill"></i> PROSES PEMBAYARAN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>