<?php
/**
 * TodoList PowerPuff - System Check
 * File untuk mengecek konfigurasi sistem
 */

session_start();

$checks = [];

// Check 1: PHP Version
$checks['PHP Version'] = [
    'required' => '7.4+',
    'current' => PHP_VERSION,
    'status' => version_compare(PHP_VERSION, '7.4.0', '>='),
    'icon' => '✓'
];

// Check 2: Directory creation
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    @mkdir($dataDir, 0755, true);
}
$checks['Data Directory'] = [
    'required' => 'Writable folder',
    'current' => is_writable($dataDir) ? 'Writable' : 'Not writable',
    'status' => is_dir($dataDir) && is_writable($dataDir),
    'icon' => is_dir($dataDir) ? '✓' : '✕'
];

// Check 3: Session
$checks['Session Support'] = [
    'required' => 'Enabled',
    'current' => ini_get('session.use_cookies') ? 'Enabled' : 'Disabled',
    'status' => ini_get('session.use_cookies'),
    'icon' => ini_get('session.use_cookies') ? '✓' : '✕'
];

// Check 4: JSON Functions
$checks['JSON Functions'] = [
    'required' => 'Available',
    'current' => function_exists('json_encode') ? 'Available' : 'Not available',
    'status' => function_exists('json_encode'),
    'icon' => function_exists('json_encode') ? '✓' : '✕'
];

// Check 5: File Operations
$checks['File Operations'] = [
    'required' => 'Available',
    'current' => function_exists('file_get_contents') ? 'Available' : 'Not available',
    'status' => function_exists('file_get_contents'),
    'icon' => function_exists('file_get_contents') ? '✓' : '✕'
];

// Check 6: Password Hashing
$checks['Password Hashing'] = [
    'required' => 'Argon2ID',
    'current' => defined('PASSWORD_ARGON2ID') ? 'Available' : 'Not available (using Bcrypt)',
    'status' => defined('PASSWORD_ARGON2ID'),
    'icon' => defined('PASSWORD_ARGON2ID') ? '✓' : '⚠'
];

// Check 7: Users File
$usersFile = $dataDir . '/users.json';
if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([], JSON_PRETTY_PRINT));
}
$checks['Users Data File'] = [
    'required' => 'Exists & writable',
    'current' => file_exists($usersFile) ? 'Exists' : 'Not exists',
    'status' => file_exists($usersFile) && is_writable($usersFile),
    'icon' => file_exists($usersFile) ? '✓' : '✕'
];

// Check 8: Filter Functions
$checks['Filter Functions'] = [
    'required' => 'Available',
    'current' => function_exists('filter_var') ? 'Available' : 'Not available',
    'status' => function_exists('filter_var'),
    'icon' => function_exists('filter_var') ? '✓' : '✕'
];

// Count status
$allGood = true;
foreach ($checks as $check) {
    if (!$check['status']) {
        $allGood = false;
        break;
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Check - TodoList PowerPuff</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 40px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .subtitle {
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .status-good {
            background: #d4edda;
            color: #155724;
        }

        .status-warning {
            background: #fff3cd;
            color: #856404;
        }

        .check-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ecf0f1;
            gap: 15px;
        }

        .check-item:last-child {
            border-bottom: none;
        }

        .check-icon {
            font-size: 24px;
            min-width: 30px;
        }

        .check-icon.success {
            color: #27ae60;
        }

        .check-icon.warning {
            color: #f39c12;
        }

        .check-icon.error {
            color: #e74c3c;
        }

        .check-content {
            flex: 1;
        }

        .check-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .check-detail {
            font-size: 12px;
            color: #7f8c8d;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #ecf0f1;
            color: #2c3e50;
        }

        .btn-secondary:hover {
            background: #d5dbdb;
        }

        .info-box {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            font-size: 13px;
            color: #0c5460;
            line-height: 1.6;
        }

        .check-title {
            font-weight: 600;
            margin: 20px 0 15px;
            color: #2c3e50;
            font-size: 16px;
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px;
            }

            h1 {
                font-size: 24px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 System Check</h1>
        <p class="subtitle">TodoList PowerPuff - Verifikasi Konfigurasi Sistem</p>

        <?php if ($allGood): ?>
            <div class="status-badge status-good">
                ✓ SEMUA SISTEM BERJALAN DENGAN BAIK
            </div>
        <?php else: ?>
            <div class="status-badge status-warning">
                ⚠ ADA BEBERAPA ITEM YANG PERLU DIPERBAIKI
            </div>
        <?php endif; ?>

        <div class="check-title">Hasil Pemeriksaan:</div>

        <?php foreach ($checks as $name => $check): ?>
            <div class="check-item">
                <div class="check-icon <?= $check['status'] ? 'success' : ($check['icon'] === '⚠' ? 'warning' : 'error') ?>">
                    <?= $check['icon'] ?>
                </div>
                <div class="check-content">
                    <div class="check-label"><?= $name ?></div>
                    <div class="check-detail">
                        Diperlukan: <strong><?= $check['required'] ?></strong> 
                        | Kondisi: <strong><?= $check['current'] ?></strong>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="info-box">
            <strong>ℹ️ Informasi:</strong><br>
            Sistem sudah siap untuk menjalankan aplikasi TodoList PowerPuff. Pastikan folder 
            <code>data/</code> memiliki write permissions agar aplikasi dapat menyimpan data pengguna dan tugas.
        </div>

        <div class="action-buttons">
            <?php if ($allGood): ?>
                <a href="login.php" class="btn btn-primary">→ Mulai Aplikasi (Login)</a>
            <?php else: ?>
                <a href="SETUP_GUIDE.php" class="btn btn-secondary">📖 Setup Guide</a>
                <a href="login.php" class="btn btn-primary">Coba Lanjut</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
