<?php
session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = 'Email harus diisi';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid';
    } else {
        // Cek apakah email terdaftar
        $users_file = 'data/users.json';
        if (file_exists($users_file)) {
            $users = json_decode(file_get_contents($users_file), true) ?? [];
            $email_found = false;

            foreach ($users as &$user) {
                if ($user['email'] === $email) {
                    $email_found = true;
                    // Generate reset token (dalam aplikasi real, ini harus disimpan ke database dengan expiry time)
                    $reset_token = bin2hex(random_bytes(32));
                    $user['reset_token'] = $reset_token;
                    $user['reset_token_time'] = time();
                    break;
                }
            }

            if ($email_found) {
                // Simpan perubahan (dalam aplikasi real, kirim email dengan link reset)
                file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
                $success = 'Instruksi reset password telah dikirim ke email Anda. Silahkan cek email Anda dan ikuti link yang diberikan.';
            } else {
                $error = 'Email tidak ditemukan dalam sistem kami';
            }
        } else {
            $error = 'Data pengguna tidak ditemukan';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - TodoList PowerPuff</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .auth-box {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            padding: 48px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-header h1 {
            font-size: 28px;
            color: #2c3e50;
            margin: 0 0 8px;
            font-weight: 700;
        }

        .auth-header p {
            color: #7f8c8d;
            font-size: 14px;
            margin: 0;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .btn-reset {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 16px;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            color: #bdc3c7;
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #ecf0f1;
        }

        .back-link {
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #764ba2;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: #fdeaea;
            color: #c53030;
            border: 1px solid #fbd38d;
        }

        .alert-success {
            background: #eaf5e9;
            color: #228a22;
            border: 1px solid #9ae6b4;
        }

        .form-group input::placeholder {
            color: #bdc3c7;
        }

        @media (max-width: 480px) {
            .auth-box {
                padding: 32px 24px;
                border-radius: 12px;
            }

            .auth-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Lupa Password?</h1>
                <p>Masukkan email Anda untuk menerima instruksi reset password</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <strong>⚠️ Error:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <strong>✓ Berhasil:</strong> <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">Email Anda</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="nama@example.com"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        required
                        autocomplete="email"
                    >
                </div>

                <button type="submit" class="btn-reset">Kirim Reset Link</button>
            </form>

            <div class="divider">atau</div>

            <div class="back-link">
                <a href="login.php">← Kembali ke Login</a>
            </div>
        </div>
    </div>

    <script src="auth.js"></script>
</body>
</html>
