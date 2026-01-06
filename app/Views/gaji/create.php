<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h3>Generate Gaji Bulanan</h3>
    
    <div class="card shadow mt-3 col-md-6">
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fa-solid fa-info-circle"></i> Sistem akan otomatis memotong gaji <b>Rp 100.000</b> untuk setiap status <b>ALPA</b>.
            </div>

            <form action="<?= base_url('gaji/process') ?>" method="post">
                <div class="mb-3">
                    <label>Pilih Periode Bulan</label>
                    <input type="month" name="bulan" class="form-control" value="<?= date('Y-m') ?>" required>
                </div>

                <div class="mb-3">
                    <label>Pilih Karyawan</label>
                    <select name="employee_id" class="form-select" required>
                        <option value="">-- Pilih Nama --</option>
                        <?php foreach($employees as $e): ?>
                            <option value="<?= $e['id'] ?>">
                                <?= $e['nama_lengkap'] ?> (Gaji Pokok: Rp <?= number_format($e['gaji_pokok']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-success w-100 p-3">
                    <i class="fa-solid fa-gear"></i> PROSES HITUNG GAJI
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>