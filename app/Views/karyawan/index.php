<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Data Karyawan</h3>
        <a href="<?= base_url('karyawan/create') ?>" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i> Tambah Pegawai
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Posisi</th>
                        <th>No HP</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($employees as $k): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $k['nama_lengkap'] ?></td>
                        <td><span class="badge bg-info text-dark"><?= $k['posisi'] ?></span></td>
                        <td><?= $k['no_hp'] ?></td>
                        <td>Rp <?= number_format($k['gaji_pokok'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($k['tunjangan'], 0, ',', '.') ?></td>
                        <td>
                            <a href="<?= base_url('karyawan/delete/'.$k['id']) ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Pecat karyawan ini?')">
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

<?= $this->endSection() ?>