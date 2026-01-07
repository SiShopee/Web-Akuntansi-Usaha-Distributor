<!DOCTYPE html>
<html>
<head>
    <title>Login - Web Akuntansi</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; background-color: #f4f6f9; }
        .box { background: white; border: 1px solid #ddd; padding: 25px; border-radius: 8px; width: 320px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-top: 10px;}
        button:hover { background: #0056b3; }
        .alert { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 10px; font-size: 14px; text-align: center;}
        .link { text-align: center; margin-top: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="text-align:center; color: #333;">Login Sistem</h2>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert" style="color: #155724; background-color: #d4edda;"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/process_login') ?>" method="post">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required>
            
            <label>Jabatan</label>
            <select name="role" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="pemilik">Pemilik / Admin</option>
                <option value="kasir">Kasir</option>
                <option value="staff_gudang">Staff Gudang</option>
                <option value="sales">Sales</option>
            </select>

            <label>Password</label>
            <input type="password" name="password" id="inputPassword" placeholder="Masukkan password" required>
            
            <div style="font-size: 13px; margin-bottom: 10px;">
                <input type="checkbox" onclick="togglePassword()"> Tampilkan Password
            </div>
            
            <button type="submit">Masuk</button>
        </form>

        <div class="link">
            Belum punya akun? <a href="<?= base_url('register') ?>">Daftar disini</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            var x = document.getElementById("inputPassword");
            x.type = (x.type === "password") ? "text" : "password";
        }
    </script>
</body>
</html>