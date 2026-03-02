<?php
session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi input
    if (empty($email) || empty($password)) {
        $error = 'Email dan password harus diisi';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid';
    } else {
        // Baca data dari file JSON
        $users_file = 'data/users.json';
        if (file_exists($users_file)) {
            $users = json_decode(file_get_contents($users_file), true) ?? [];
            
            // Cari user berdasarkan email
            $user_found = false;
            foreach ($users as $user) {
                if ($user['email'] === $email) {
                    // Verifikasi password
                    if (password_verify($password, $user['password'])) {
                        // Login berhasil
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['name'];
                        $_SESSION['user_email'] = $user['email'];
                        $success = 'Login berhasil! Mengalihkan...';
                        // Redirect setelah 1 detik
                        header('Refresh: 1; url=index.php');
                    } else {
                        $error = 'Email atau password salah';
                    }
                    $user_found = true;
                    break;
                }
            }
            
            if (!$user_found) {
                $error = 'Email tidak ditemukan';
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
    <title>Login - TodoList PowerPuff</title>
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

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .remember-forgot a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .remember-forgot a:hover {
            color: #764ba2;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .checkbox-wrapper label {
            margin: 0;
            cursor: pointer;
            color: #7f8c8d;
        }

        .btn-login {
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

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
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

        .signup-link {
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
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

            .remember-forgot {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Login</h1>
                <p>Masuk ke akun TodoList PowerPuff Anda</p>
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

            <form method="POST" class="auth-form" id="loginForm">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="nama@example.com"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <div class="remember-forgot">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <a href="forgot-password.php">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="divider">atau</div>

            <div class="signup-link">
                Belum punya akun? <a href="register.php">Daftar sekarang</a>
            </div>
        </div>
    </div>

    <script src="auth.js"></script>
</body>
</html>
