<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h3>Input Absensi Harian</h3>
    
    <div class="card shadow mt-3 col-md-6">
        <div class="card-body">
            <form action="<?= base_url('absensi/store') ?>" method="post">
                
                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="mb-3">
                    <label>Nama Karyawan</label>
                    <select name="employee_id" class="form-select" required>
                        <option value="">-- Pilih Karyawan --</option>
                        <?php foreach($employees as $e): ?>
                            <option value="<?= $e['id'] ?>"><?= $e['nama_lengkap'] ?> - <?= $e['posisi'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Status Kehadiran</label>
                    <select name="status" class="form-select" required>
                        <option value="hadir">Hadir</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="alpa">Alpa (Tanpa Keterangan)</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jam Masuk</label>
                        <input type="time" name="jam_masuk" class="form-control" value="08:00">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Jam Keluar</label>
                        <input type="time" name="jam_keluar" class="form-control" value="17:00">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Simpan Absensi</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>