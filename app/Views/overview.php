<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<style>
    /* CSS PRINTING */
    @media print {
        #sidebar, .btn, .no-print, header, footer { display: none !important; }
        #content-wrapper { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        body { -webkit-print-color-adjust: exact; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h3 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Overview</h3>
        <button onclick="window.print()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm no-print">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report (Cetak)
        </button>
    </div>

    <?php if(!empty($pesan_masuk)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-left-danger shadow h-100 py-2 bg-warning bg-opacity-10" style="border-left: 5px solid #e74a3b;">
                    <div class="card-body">
                        <h5 class="font-weight-bold text-danger mb-3">
                            <i class="fa-solid fa-bell fa-shake me-2"></i> Pesan Masuk (Request Baru)
                        </h5>
                        <?php foreach($pesan_masuk as $msg): ?>
                            <div class="alert alert-light border shadow-sm d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong class="text-dark">
                                        <i class="fa-solid fa-user-tag me-1 text-primary"></i> <?= esc($msg['sender_name']) ?>
                                    </strong>
                                    <span class="text-muted small ms-2">(<?= date('d M H:i', strtotime($msg['created_at'])) ?>)</span>
                                    <div class="mt-1 text-dark">"<?= esc($msg['message']) ?>"</div>
                                </div>
                                <a href="<?= base_url('pesan/baca/'.$msg['id']) ?>" class="btn btn-sm btn-success shadow-sm" title="Tandai Selesai">
                                    <i class="fa-solid fa-check me-1"></i> Oke, Siap!
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if(session()->get('role') == 'admin' || session()->get('role') == 'pemilik'): ?>
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
    <?php endif; ?> 
    <?php if(session()->get('role') != 'admin' && session()->get('role') != 'pemilik'): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow h-100 border-left-info" style="border-left: 5px solid #36b9cc;">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="font-weight-bold text-gray-800">
                                Halo, <?= session()->get('nama_lengkap') ?? session()->get('username') ?>! 👋
                            </h4>
                            <p class="mb-0 text-muted">Tanggal Hari Ini: <strong><?= date('d F Y') ?></strong></p>
                        </div>
                        <div class="col-md-4 text-end text-right">
                            <?php if($sudah_absen): ?>
                                <button class="btn btn-success btn-lg disabled" style="cursor: not-allowed; opacity: 1;">
                                    <i class="fa-solid fa-check-circle me-2"></i> Sudah Absen
                                </button>
                                <div class="small text-success mt-2 fw-bold">Masuk jam: <?= $jam_absen ?> WIB</div>
                            <?php else: ?>
                                <form action="<?= base_url('dashboard/absen') ?>" method="post">
                                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                        <i class="fa-solid fa-fingerprint me-2"></i> Klik untuk Absen Masuk
                                    </button>
                                </form>
                                <div class="small text-muted mt-2">*Catat kehadiranmu sekarang.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
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
                    <?php if(session()->get('role') != 'kasir' && session()->get('role') != 'sales'): ?>
                        <a href="<?= base_url('produk') ?>" class="small text-danger text-decoration-none">Kelola Barang &rarr;</a>
                    <?php else: ?>
                        <button type="button" class="btn btn-sm btn-warning text-dark shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPesan">
                            <i class="fa-solid fa-paper-plane me-1"></i> Kirim Pesan ke Gudang
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-info"><i class="fa-solid fa-trophy me-2"></i>Top Transaksi</h6>
                </div>
                <div class="card-body p-0">
                     <?php if(empty($transaksi_baru)): ?>
                        <div class="p-3 text-center text-muted"><small>Belum ada transaksi.</small></div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0">
                                <thead class="bg-light">
                                    <tr><th class="ps-3">No</th><th>Total</th><th>Kasir</th></tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach($transaksi_baru as $trx): ?>
                                    <tr>
                                        <td class="ps-3 text-muted small"><?= $i++ ?>.</td>
                                        <td class="fw-bold text-dark">Rp <?= number_format($trx['grand_total'], 0, ',', '.') ?></td>
                                        <td class="small"><i class="fa-solid fa-user-circle me-1 text-gray-400"></i><?= esc($trx['kasir'] ?? 'Admin') ?></td>
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
    const labels = <?= json_encode(array_column($chart_data, 'tgl')); ?>;
    const dataOmzet = <?= json_encode(array_column($chart_data, 'total')); ?>;
    const ctx = document.getElementById('myAreaChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Omzet Penjualan',
                data: dataOmzet,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 3,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
            scales: {
                x: { grid: { display: false }, ticks: { maxTicksLimit: 7 } },
                y: { ticks: { maxTicksLimit: 5, callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); } } },
            },
            plugins: { legend: { display: false } }
        }
    });
</script>

<div class="modal fade" id="modalPesan" tabindex="-1" aria-labelledby="modalPesanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark fw-bold" id="modalPesanLabel">
                    <i class="fa-solid fa-comments me-2"></i>Hubungi Staff Gudang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('pesan/kirim') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="tujuan" value="staff_gudang">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pesan / Request Stok:</label>
                        <textarea name="isi_pesan" class="form-control" rows="4" placeholder="Contoh: Stok Mouse tinggal 4, tolong restock segera ya!" required></textarea>
                    </div>
                    <div class="alert alert-info small py-2"><i class="fa-solid fa-circle-info me-1"></i> Pesan ini akan masuk ke notifikasi Staff Gudang.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Sekarang <i class="fa-solid fa-paper-plane ms-1"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
