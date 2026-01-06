<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-4">Laporan Keuangan & Laba Rugi</h3>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Omzet (Penjualan)</div>
                    <div class="h5 mb-0 font-weight-bold">Rp <?= number_format($total_penjualan) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Modal Barang</div>
                    <div class="h5 mb-0 font-weight-bold">Rp <?= number_format($total_modal) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Beban Gaji</div>
                    <div class="h5 mb-0 font-weight-bold">Rp <?= number_format($total_gaji) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Laba Bersih Usaha</div>
                    <div class="h5 mb-0 font-weight-bold">Rp <?= number_format($laba_bersih) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Analisis Arus Kas</h6>
        </div>
        <div class="card-body">
            <p>
                <strong>Status Keuangan:</strong> 
                <?php if($laba_bersih > 0): ?>
                    <span class="text-success fw-bold">PROFIT (UNTUNG)</span>
                <?php else: ?>
                    <span class="text-danger fw-bold">LOSS (RUGI)</span>
                <?php endif; ?>
            </p>
            <div class="progress" style="height: 30px;">
                <?php 
                    $total_uang = $total_penjualan + $total_gaji + $total_modal;
                    $persen_profit = ($total_penjualan > 0) ? ($laba_bersih / $total_penjualan) * 100 : 0;
                ?>
                <div class="progress-bar bg-success" role="progressbar" style="width: 100%">
                    Arus Kas Bersih
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>