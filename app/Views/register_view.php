<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SI Akuntan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #1e272e 0%, #2c3e50 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
        }

        .login-card {
            background: #fff;
            width: 100%;
            max-width: 450px; /* Lebih lebar sedikit dari login */
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: #27ae60; /* Hijau untuk Register (Pembeda) */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 25px;
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.4);
        }

        .form-control, .form-select {
            background: #f8f9fa;
            border: none;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            background: #fff;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.2);
            transform: translateY(-2px);
        }

        .btn-register {
            width: 100%;
            background: linear-gradient(to right, #27ae60, #2ecc71);
            border: none;
            padding: 12px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            letter-spacing: 1px;
            transition: transform 0.2s;
        }

        .btn-register:hover {
            transform: scale(1.02);
            color: white;
        }

        .link-text { color: #2c3e50; text-decoration: none; font-weight: 600; }
        .link-text:hover { color: #27ae60; text-decoration: underline; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <div class="brand-logo">
            <i class="fa-solid fa-user-plus"></i>
        </div>

        <h4 class="fw-bold mb-1">Buat Akun Baru</h4>
        <p class="text-muted mb-4 small">Bergabunglah dengan tim kami.</p>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2 small rounded-3 border-0 bg-danger text-white bg-opacity-75 mb-3">
                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register/store') ?>" method="post">
            <div class="text-start">
                <input type="text" name="username" class="form-control" placeholder="Tentukan Username" required autocomplete="off">
            </div>
            
            <div class="text-start">
                <input type="password" name="password" class="form-control" placeholder="Tentukan Password" required>
            </div>

            <div class="text-start">
                <input type="password" name="password_confirm" class="form-control" placeholder="Ulangi Password" required>
            </div>

            <div class="text-start">
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Jabatan --</option>
                    <option value="kasir">Kasir</option>
                    <option value="staff_gudang">Staff Gudang</option>
                    <option value="sales">Sales</option>
                    </select>
            </div>

            <button type="submit" class="btn btn-register mb-3 shadow">
                DAFTAR AKUN <i class="fa-solid fa-paper-plane ms-2"></i>
            </button>
        </form>

        <p class="text-muted small mt-2">
            Sudah punya akun? <a href="<?= base_url('login') ?>" class="link-text">Login di sini</a>
        </p>
    </div>

</body>
</html>