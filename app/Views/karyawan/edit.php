<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-4">Edit Data Karyawan</h3>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit: <?= $karyawan['nama_lengkap'] ?></h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('karyawan/update/' . $karyawan['id']) ?>" method="post">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= $karyawan['nama_lengkap'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Posisi / Jabatan</label>
                            <select name="posisi" class="form-select" required>
                                <option value="Kasir" <?= $karyawan['posisi'] == 'Kasir' ? 'selected' : '' ?>>Kasir</option>
                                <option value="Staff Gudang" <?= $karyawan['posisi'] == 'Staff Gudang' ? 'selected' : '' ?>>Staff Gudang</option>
                                <option value="Sales" <?= $karyawan['posisi'] == 'Sales' ? 'selected' : '' ?>>Sales</option>
                                <option value="Staff" <?= $karyawan['posisi'] == 'Staff' ? 'selected' : '' ?>>Staff Umum</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" class="form-control" value="<?= $karyawan['no_hp'] ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <small><i class="fa-solid fa-money-bill"></i> Atur Gaji Pokok & Tunjangan di sini.</small>
                        </div>
                        <div class="mb-3">
                            <label>Gaji Pokok (Rp)</label>
                            <input type="number" name="gaji_pokok" class="form-control" value="<?= $karyawan['gaji_pokok'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Tunjangan (Rp)</label>
                            <input type="number" name="tunjangan" class="form-control" value="<?= $karyawan['tunjangan'] ?>" required>
                        </div>
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan Perubahan</button>
                <a href="<?= base_url('karyawan') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>