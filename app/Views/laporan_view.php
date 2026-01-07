<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="h3 mb-0 text-gray-800 font-weight-bold">Laporan Keuangan</h3>
        <button onclick="window.print()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Laporan
        </button>
    </div>

    <div class="row">
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2" style="border-left: 5px solid #4e73df;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Omzet (Masuk)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($omzet, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2" style="border-left: 5px solid #f6c23e;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Modal Barang (HPP)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($modal, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2" style="border-left: 5px solid #e74a3b;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Beban Gaji</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($gaji, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2" style="border-left: 5px solid #1cc88a;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Laba Bersih Usaha</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($laba, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 bg-white d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa-solid fa-file-invoice-dollar me-2"></i>Rincian Laba Rugi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="fw-bold text-gray-800 py-3">Total Penjualan (Omzet)</td>
                                    <td class="text-end fw-bold text-primary py-3">Rp <?= number_format($omzet, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-4 pt-3"><i class="fa-solid fa-minus text-danger me-2" style="font-size: 0.8rem;"></i>Biaya Modal Barang (HPP)</td>
                                    <td class="text-end text-danger pt-3">- Rp <?= number_format($modal, 0, ',', '.') ?></td>
                                </tr>
                                <tr class="border-bottom border-2">
                                    <td class="fw-bold ps-4 pb-3">Laba Kotor (Gross Profit)</td>
                                    <td class="text-end fw-bold text-gray-800 pb-3">Rp <?= number_format($omzet - $modal, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-4 pt-3"><i class="fa-solid fa-minus text-danger me-2" style="font-size: 0.8rem;"></i>Beban Gaji Karyawan</td>
                                    <td class="text-end text-danger pt-3">- Rp <?= number_format($gaji, 0, ',', '.') ?></td>
                                </tr>
                                
                                <tr class="bg-light mt-3">
                                    <td class="fw-bold text-uppercase pt-4 pb-4 ps-3">Laba Bersih Usaha</td>
                                    <td class="text-end fw-bold pt-4 pb-4 pe-3 <?= $laba > 0 ? 'text-success' : 'text-danger' ?>" style="font-size: 1.3rem;">
                                        Rp <?= number_format($laba, 0, ',', '.') ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fa-solid fa-crown me-2"></i>Produk Terlaris
                    </h6>
                    <span class="badge bg-warning text-dark shadow-sm">Top 5</span>
                </div>
                <div class="card-body">
                    <?php if(empty($top_products)): ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-box-open fa-3x mb-3 text-gray-300"></i><br>
                            Belum ada data penjualan.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th class="text-center">Terjual</th>
                                        <th class="text-end">Kontribusi Uang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($top_products as $index => $item): ?>
                                    <tr>
                                        <td class="fw-bold text-gray-700">
                                            <?php 
                                                if($index == 0) echo '<span class="me-2" style="font-size:1.2em">🥇</span>'; 
                                                elseif($index == 1) echo '<span class="me-2" style="font-size:1.2em">🥈</span>'; 
                                                elseif($index == 2) echo '<span class="me-2" style="font-size:1.2em">🥉</span>'; 
                                                else echo '<span class="me-2 text-muted fw-light" style="width:20px; display:inline-block; text-align:center">'.($index+1).'.</span>';
                                            ?>
                                            <?= esc($item['nama_produk']) ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info text-white rounded-pill px-3 shadow-sm">
                                                <?= $item['terjual'] ?> Unit
                                            </span>
                                        </td>
                                        <td class="text-end small font-weight-bold text-success">
                                            + Rp <?= number_format($item['total_uang'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>