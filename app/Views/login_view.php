<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SI Akuntan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            /* Background Gradasi Senada dengan Dashboard */
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
            max-width: 400px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            background: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }

        .form-control {
            background: #f8f9fa;
            border: none;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
            transition: all 0.3s;
        }

        .form-control:focus {
            background: #fff;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            transform: translateY(-2px);
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(to right, #2c3e50, #3498db);
            border: none;
            padding: 12px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            letter-spacing: 1px;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            transform: scale(1.02);
            color: white;
        }

        .link-text { color: #2c3e50; text-decoration: none; font-weight: 600; }
        .link-text:hover { color: #3498db; text-decoration: underline; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <div class="brand-logo">
            <i class="fa-solid fa-calculator"></i>
        </div>

        <h4 class="fw-bold mb-1">Selamat Datang</h4>
        <p class="text-muted mb-4 small">Silakan login untuk mengelola bisnis.</p>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2 small rounded-3 border-0 bg-danger text-white bg-opacity-75 mb-3">
                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success py-2 small rounded-3 border-0 bg-success text-white bg-opacity-75 mb-3">
                <i class="fa-solid fa-check-circle me-1"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login/auth') ?>" method="post">
            <div class="text-start">
                <input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="off">
            </div>
            
            <div class="text-start">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="mb-3">
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Jabatan Anda --</option>
                    <option value="pemilik">Pemilik / Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="staff_gudang">Staff Gudang</option>
                    <option value="sales">Sales</option>
                </select>
            </div>

            <button type="submit" class="btn btn-login mb-3 shadow">
                MASUK SEKARANG <i class="fa-solid fa-arrow-right ms-2"></i>
            </button>
        </form>

        <p class="text-muted small mt-2">
            Belum punya akun? <a href="<?= base_url('register') ?>" class="link-text">Daftar di sini</a>
        </p>
    </div>

</body>
</html>