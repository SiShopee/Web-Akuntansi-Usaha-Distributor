<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Akun Baru</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; background-color: #f4f6f9; }
        .box { background: white; border: 1px solid #ddd; padding: 25px; border-radius: 8px; width: 350px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-top: 10px;}
        button:hover { background: #218838; }
        .link { text-align: center; margin-top: 15px; font-size: 14px; }
        .alert { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 4px; font-size: 13px; margin-bottom: 10px;}
    </style>
</head>
<body>
    <div class="box">
        <h2 style="text-align:center; color: #333;">Daftar Akun</h2>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/process_register') ?>" method="post">

            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" placeholder="Nama sesuai KTP" required>

            <label>No HP</label>
            <input type="text" name="no_hp" placeholder="08xxxxxxxx" required>
            
            <label>Username</label>
            <input type="text" name="username" placeholder="Buat username unik" required>
            
            <label>Jabatan (Role)</label>
            <select name="role" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="kasir">Kasir</option>
                <option value="staff_gudang">Staff Gudang</option>
                <option value="sales">Sales</option>
            </select>

            <label>Password</label>
            <input type="password" name="password" placeholder="Min. 8 karakter (Huruf & Angka)" required>
            
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirm" placeholder="Ketik ulang password" required>

            <button type="submit">Daftar Sekarang</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="<?= base_url('login') ?>">Login disini</a>
        </div>
    </div>
</body>
</html>