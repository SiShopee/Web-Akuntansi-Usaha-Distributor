<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Overview</h3>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-start border-4 border-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Penjualan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></div>
                            <small class="text-muted">Omzet Kotor</small>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-start border-4 border-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Laba Bersih</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($laba_bersih, 0, ',', '.') ?></div>
                            <small class="text-muted">Keuntungan Perusahaan</small>
                        </div>
                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-start border-4 border-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Karyawan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_karyawan ?> Orang</div>
                            <small class="text-muted">Total Tim</small>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa-solid fa-chart-area me-2"></i>Tren Penjualan (7 Hari Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 320px;">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i>Stok Menipis!</h6>
                </div>
                <div class="card-body p-0">
                    <?php if(empty($stok_menipis)): ?>
                        <div class="p-3 text-center text-success"><small>Stok Aman Semua! 👍</small></div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach($stok_menipis as $barang): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $barang['name_barang'] ?? $barang['nama_barang'] ?>
                                <span class="badge bg-danger rounded-pill"><?= $barang['stok'] ?> Unit</span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-center bg-white">
                    <a href="<?= base_url('produk') ?>" class="small text-danger text-decoration-none">Kelola Barang &rarr;</a>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-info"><i class="fa-solid fa-receipt me-2"></i>Transaksi Baru</h6>
                </div>
                <div class="card-body p-0">
                     <?php if(empty($transaksi_baru)): ?>
                        <div class="p-3 text-center text-muted"><small>Belum ada transaksi.</small></div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>Total</th>
                                        <th>Kasir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($transaksi_baru as $trx): ?>
                                    <tr>
                                        <td class="ps-3 text-muted small">#<?= $trx['id'] ?></td>
                                        <td class="fw-bold text-dark">Rp <?= number_format($trx['total_harga'],0,',','.') ?></td>
                                        <td class="small"><?= $trx['kasir'] ?? 'Admin' ?></td>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil data dari PHP
    const labels = <?= json_encode(array_column($chart_data, 'tgl')); ?>;
    const dataOmzet = <?= json_encode(array_column($chart_data, 'total')); ?>;

    const ctx = document.getElementById('myAreaChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line', // Jenis Grafik Garis
        data: {
            labels: labels, // Tanggal
            datasets: [{
                label: 'Omzet Penjualan',
                data: dataOmzet, // Nominal Uang
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 3,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: 'rgba(78, 115, 223, 1)',
                pointHoverRadius: 3,
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                tension: 0.3, // Garis melengkung halus
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
            scales: {
                x: { grid: { display: false, drawBorder: false }, ticks: { maxTicksLimit: 7 } },
                y: { 
                    ticks: { maxTicksLimit: 5, padding: 10, callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); } },
                    grid: { color: "rgb(234, 236, 244)", zeroLineColor: "rgb(234, 236, 244)", drawBorder: false, borderDash: [2], zeroLineBorderDash: [2] }
                },
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>