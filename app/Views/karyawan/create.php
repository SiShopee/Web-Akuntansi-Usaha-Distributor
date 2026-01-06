<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h3>Input Data Pegawai Baru</h3>
    
    <div class="card shadow mt-3 col-md-8">
        <div class="card-body">
            <form action="<?= base_url('karyawan/store') ?>" method="post">
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Posisi / Jabatan</label>
                        <select name="posisi" class="form-select">
                            <option value="Staff Gudang">Staff Gudang</option>
                            <option value="Kasir">Kasir</option>
                            <option value="Sales">Sales</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>No HP (WhatsApp)</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>
                </div>
                
                <h5 class="mt-3 text-primary">Informasi Gaji</h5>
                <hr>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Gaji Pokok (Rp)</label>
                        <input type="number" name="gaji_pokok" class="form-control" placeholder="Contoh: 3000000" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tunjangan (Makan/Transport)</label>
                        <input type="number" name="tunjangan" class="form-control" placeholder="Contoh: 500000" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Simpan Data</button>
                <a href="<?= base_url('karyawan') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>