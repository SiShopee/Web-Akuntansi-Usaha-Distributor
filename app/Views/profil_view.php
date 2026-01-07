<?= $this->extend('dashboard_view') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-4 text-gray-800">Edit Profil Saya</h3>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4 text-center p-4">
                <div class="card-body">
                    <img src="<?= base_url('uploads/' . ($user['foto'] ? $user['foto'] : 'default.png')) ?>" 
                         class="img-thumbnail rounded-circle mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover;"
                         onerror="this.src='https://ui-avatars.com/api/?name=<?= $user['username'] ?>&background=random'">
                    
                    <h5><?= $user['username'] ?></h5>
                    <p class="text-muted text-uppercase"><?= str_replace('_', ' ', $user['role']) ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir Perubahan Data</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('profil/update') ?>" method="post" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label>Nama Lengkap (Tampilan)</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= $user['nama_lengkap'] ?>">
                        </div>

                        <div class="mb-3">
                            <label>Username (Untuk Login)</label>
                            <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Ganti Foto Profil</label>
                            <input type="file" name="foto" class="form-control">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                        </div>

                        <hr>
                        <div class="alert alert-warning">
                            <small><i class="fa-solid fa-lock"></i> Hanya isi di bawah ini jika ingin mengganti password.</small>
                        </div>

                        <div class="mb-3">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika password tetap sama">
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>