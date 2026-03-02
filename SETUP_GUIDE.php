<?php
/**
 * TodoList PowerPuff - Setup Guide
 * 
 * Panduan lengkap instalasi dan penggunaan aplikasi
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Guide - TodoList PowerPuff</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
            background: white;
            border-radius: 8px;
            margin-top: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #667eea;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        
        h2 {
            color: #2c3e50;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        
        h3 {
            color: #34495e;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        
        p {
            margin-bottom: 10px;
            color: #555;
        }
        
        ul, ol {
            margin-left: 20px;
            margin-bottom: 15px;
        }
        
        li {
            margin-bottom: 8px;
        }
        
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #d63384;
            font-size: 0.9em;
        }
        
        .code-block {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            line-height: 1.4;
        }
        
        .success {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
            color: #155724;
        }
        
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
            color: #856404;
        }
        
        .info {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
            color: #0c5460;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        table th {
            background: #667eea;
            color: white;
        }
        
        table tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .button {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            transition: background 0.3s;
        }
        
        .button:hover {
            background: #764ba2;
        }
        
        .file-list {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            margin: 15px 0;
        }
        
        .file-list strong {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Setup Guide - TodoList PowerPuff v1.0</h1>
        
        <div class="success">
            <strong>✓ Selamat!</strong> Anda telah mengunduh aplikasi TodoList PowerPuff. Panduan ini akan membantu Anda setup dan menggunakan aplikasi dengan sempurna.
        </div>

        <h2>1. Syarat Minimum</h2>
        <ul>
            <li>XAMPP atau server PHP lokal dengan PHP 7.4+</li>
            <li>Browser modern (Chrome, Firefox, Safari, Edge)</li>
            <li>Akses ke folder htdocs XAMPP</li>
            <li>Minimal 50MB ruang disk</li>
        </ul>

        <h2>2. Instalasi</h2>
        <h3>Langkah 1: Copy File</h3>
        <ol>
            <li>Extract folder <code>todolist-powerpuff</code> yang sudah didownload</li>
            <li>Copy folder ke lokasi: <code>F:\xampp\htdocs\</code></li>
            <li>Struktur harus seperti: <code>F:\xampp\htdocs\todolist-powerpuff\</code></li>
        </ol>

        <h3>Langkah 2: Start XAMPP</h3>
        <ol>
            <li>Buka XAMPP Control Panel</li>
            <li>Klik tombol "Start" untuk Apache dan MySQL (opsional)</li>
            <li>Tunggu sampai status berwarna hijau</li>
        </ol>

        <h3>Langkah 3: Akses Aplikasi</h3>
        <p>Buka browser dan akses:</p>
        <div class="code-block">
http://localhost/todolist-powerpuff/
        </div>
        <p>Anda akan otomatis diarahkan ke halaman login.</p>

        <div class="success">
            <strong>✓ Instalasi Berhasil</strong> jika Anda melihat halaman login dengan desain modern.
        </div>

        <h2>3. Struktur File</h2>
        <div class="file-list">
            <strong>File Utama:</strong><br>
            <ul>
                <li><code>index.php</code> - Dashboard utama (perlu login)</li>
                <li><code>login.php</code> - Halaman login</li>
                <li><code>register.php</code> - Halaman registrasi</li>
                <li><code>forgot-password.php</code> - Halaman reset password</li>
                <li><code>logout.php</code> - Script logout</li>
                <li><code>config.php</code> - Konfigurasi aplikasi</li>
            </ul>

            <strong>File Keperluan:</strong><br>
            <ul>
                <li><code>app.js</code> - JavaScript untuk manajemen tugas</li>
                <li><code>auth.js</code> - JavaScript untuk validasi form & responsive</li>
                <li><code>style.css</code> - Stylesheet utama</li>
                <li><code>.htaccess</code> - Konfigurasi Apache</li>
            </ul>

            <strong>Folder Data (Dibuat Otomatis):</strong><br>
            <ul>
                <li><code>data/</code> - Folder penyimpanan data
                    <ul>
                        <li><code>users.json</code> - Daftar user dan password hash</li>
                        <li><code>tasks_[user_id].json</code> - Tugas per user</li>
                    </ul>
                </li>
            </ul>
        </div>

        <h2>4. Penggunaan Aplikasi</h2>

        <h3>📌 Registrasi (Pertama Kali)</h3>
        <ol>
            <li>Klik tombol <strong>"Daftar sekarang"</strong> di halaman login</li>
            <li>Isi form registrasi:
                <ul>
                    <li><strong>Nama Lengkap:</strong> Minimal 3 karakter</li>
                    <li><strong>Email:</strong> Format valid (contoh: nama@example.com)</li>
                    <li><strong>Password:</strong> Minimal 6 karakter
                        <ul>
                            <li>💡 Tip: Gunakan kombinasi huruf, angka, dan simbol untuk password kuat</li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>Field indikator kekuatan password akan berubah warna:
                <ul>
                    <li><span style="color: #e74c3c;">Lemah</span> (merah)</li>
                    <li><span style="color: #f39c12;">Sedang</span> (orange)</li>
                    <li><span style="color: #3498db;">Kuat</span> (biru)</li>
                    <li><span style="color: #27ae60;">Sangat Kuat</span> (hijau)</li>
                </ul>
            </li>
            <li>Klik "Daftar" untuk menyelesaikan registrasi</li>
            <li>Lanjut ke login dengan akun baru Anda</li>
        </ol>

        <h3>🔑 Login</h3>
        <ol>
            <li>Masukkan email Anda</li>
            <li>Masukkan password Anda</li>
            <li>Opsional: Centang "Ingat saya" untuk tetap login</li>
            <li>Klik "Login"</li>
            <li>Anda akan diarahkan ke dashboard</li>
        </ol>

        <h3>✅ Dashboard & Manajemen Tugas</h3>
        <ol>
            <li><strong>Tambah Tugas:</strong>
                <ul>
                    <li>Ketik deskripsi tugas di form input</li>
                    <li>Klik "Tambah" atau tekan Enter</li>
                </ul>
            </li>
            <li><strong>Tandai Selesai:</strong>
                <ul>
                    <li>Klik tombol ✓ (centang) di sebelah tugas</li>
                    <li>Tugas akan ditandai dengan strikethrough</li>
                </ul>
            </li>
            <li><strong>Hapus Tugas:</strong>
                <ul>
                    <li>Klik tombol ✕ (silang) untuk menghapus tugas</li>
                </ul>
            </li>
            <li><strong>Logout:</strong>
                <ul>
                    <li>Klik tombol "Logout" di navbar atas</li>
                </ul>
            </li>
        </ol>

        <h3>❓ Lupa Password</h3>
        <ol>
            <li>Di halaman login, klik "Lupa password?"</li>
            <li>Masukkan email akun Anda</li>
            <li>Instruksi reset akan dikirim ke email Anda</li>
            <li>Ikuti instruksi yang diberikan</li>
        </ol>

        <h2>5. Desain & Fitur UI</h2>
        
        <h3>🎨 Warna dan Tema</h3>
        <table>
            <tr>
                <th>Elemen</th>
                <th>Warna</th>
                <th>Penggunaan</th>
            </tr>
            <tr>
                <td>Primary Gradient</td>
                <td style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 10px;">
                    #667eea → #764ba2
                </td>
                <td>Tombol, gradien background, link aktif</td>
            </tr>
            <tr>
                <td>Text Dark</td>
                <td style="background: #2c3e50; color: white; padding: 10px;">#2c3e50</td>
                <td>Text heading, text utama</td>
            </tr>
            <tr>
                <td>Background Light</td>
                <td style="background: #f8f9fa; border: 1px solid #ddd; padding: 10px;">#f8f9fa</td>
                <td>Background komponen, input fields</td>
            </tr>
            <tr>
                <td>Success</td>
                <td style="background: #27ae60; color: white; padding: 10px;">#27ae60</td>
                <td>Pesan sukses, tombol check</td>
            </tr>
            <tr>
                <td>Error</td>
                <td style="background: #e74c3c; color: white; padding: 10px;">#e74c3c</td>
                <td>Pesan error, tombol delete</td>
            </tr>
        </table>

        <h3>📱 Responsive Design</h3>
        <p>Aplikasi telah dioptimalkan untuk semua ukuran layar:</p>
        <table>
            <tr>
                <th>Tipe Device</th>
                <th>Ukuran Layar</th>
                <th>Optimasi</th>
            </tr>
            <tr>
                <td>Mobile Phone</td>
                <td>320px - 480px</td>
                <td>Full width, font-size optimized, touch-friendly buttons</td>
            </tr>
            <tr>
                <td>Tablet</td>
                <td>481px - 768px</td>
                <td>Medium layout, medium padding dan font</td>
            </tr>
            <tr>
                <td>Desktop</td>
                <td>769px+</td>
                <td>Full features, optimal spacing</td>
            </tr>
        </table>

        <h2>6. Keamanan</h2>
        <div class="info">
            <strong>ℹ️ Fitur Keamanan:</strong>
            <ul>
                <li>✓ Password di-hash dengan algoritma Argon2ID (industri terkuat)</li>
                <li>✓ Session management dengan cookie secure</li>
                <li>✓ XSS prevention dengan htmlspecialchars()</li>
                <li>✓ Input validation di server dan client</li>
                <li>✓ Per-user data isolation (setiap user punya folder tugas sendiri)</li>
                <li>✓ Apache security headers via .htaccess</li>
            </ul>
        </div>

        <h2>7. Troubleshooting</h2>

        <h3>❌ "404 Not Found" atau "Halaman tidak ditemukan"</h3>
        <div class="warning">
            <strong>Solusi:</strong>
            <ol>
                <li>Periksa folder berada di: <code>F:\xampp\htdocs\todolist-powerpuff\</code></li>
                <li>Akses dengan URL: <code>http://localhost/todolist-powerpuff/</code></li>
                <li>Jangan akses file langsung (mis: index.php)</li>
            </ol>
        </div>

        <h3>❌ "Folder data tidak ditemukan" atau error penyimpanan</h3>
        <div class="warning">
            <strong>Solusi:</strong>
            <ol>
                <li>Aplikasi akan otomatis membuat folder <code>data</code></li>
                <li>Jika error, buat folder <code>data</code> manual di folder root aplikasi</li>
                <li>Set permissions folder menjadi <code>755</code></li>
                <li>Pastikan Apache memiliki write access ke folder ini</li>
            </ol>
        </div>

        <h3>❌ "Email sudah terdaftar"</h3>
        <div class="warning">
            <strong>Solusi:</strong>
            <ol>
                <li>Email harus unik untuk setiap akun</li>
                <li>Gunakan email berbeda untuk membuat akun baru</li>
                <li>Jika lupa email, gunakan fitur "Lupa Password"</li>
            </ol>
        </div>

        <h3>❌ "Password tidak cocok" saat registrasi</h3>
        <div class="warning">
            <strong>Solusi:</strong>
            <ol>
                <li>Pastikan password dan konfirmasi password sama persis</li>
                <li>Password case-sensitive (huruf besar/kecil berbeda)</li>
                <li>Perhatikan tombol CAPS LOCK</li>
                <li>Tidak ada spasi di awal atau akhir password</li>
            </ol>
        </div>

        <h3>❌ Tugas tidak tersimpan</h3>
        <div class="warning">
            <strong>Solusi:</strong>
            <ol>
                <li>Periksa koneksi internet Anda</li>
                <li>Refresh halaman untuk reload data</li>
                <li>Periksa console browser (F12 > Console) untuk error details</li>
                <li>Pastikan folder <code>data</code> memiliki write permissions</li>
            </ol>
        </div>

        <h2>8. Tips & Trik</h2>
        <div class="success">
            <ol>
                <li>💡 <strong>Gunakan Email Real:</strong> Memudahkan recovery jika ada masalah</li>
                <li>💪 <strong>Password Kuat:</strong> Kombinasikan huruf, angka, dan simbol</li>
                <li>🔄 <strong>Data Auto-Sync:</strong> Data otomatis tersimpan ke server setiap aksi</li>
                <li>📱 <strong>Mobile Friendly:</strong> Buka di smartphone untuk full responsive experience</li>
                <li>🖥️ <strong>Cross-Device:</strong> Login dari perangkat berbeda, semua tugas tetap sinkron</li>
                <li>🗑️ <strong>Bulk Delete:</strong> Hapus tugas lama secara one-click</li>
            </ol>
        </div>

        <h2>9. Kontribusi & Feedback</h2>
        <p>Jika Anda menemukan bug atau memiliki saran untuk improvement:</p>
        <ol>
            <li>Dokumentasikan issue yang ditemukan dengan detail</li>
            <li>Screenshot/video jika diperlukan</li>
            <li>Jelaskan langkah untuk reproduce bug</li>
            <li>Sarankan solusi atau fitur baru</li>
        </ol>

        <h2>10. Informasi Teknis</h2>
        <table>
            <tr>
                <th>Item</th>
                <th>Spesifikasi</th>
            </tr>
            <tr>
                <td>Versi Aplikasi</td>
                <td>1.0.0</td>
            </tr>
            <tr>
                <td>PHP Minimum</td>
                <td>7.4+</td>
            </tr>
            <tr>
                <td>Database</td>
                <td>JSON File (no SQL database needed)</td>
            </tr>
            <tr>
                <td>Framework</td>
                <td>Vanilla PHP, JavaScript (No framework)</td>
            </tr>
            <tr>
                <td>CSS Framework</td>
                <td>Custom CSS (no Bootstrap/Tailwind)</td>
            </tr>
            <tr>
                <td>Bahasa</td>
                <td>Bahasa Indonesia</td>
            </tr>
            <tr>
                <td>Charset</td>
                <td>UTF-8</td>
            </tr>
        </table>

        <h2>11. Lisensi & Kredit</h2>
        <p>
            TodoList PowerPuff v1.0 dibuat sebagai learning project untuk demonstrasi 
            implementasi sistem login, registrasi, dan manajemen data dengan PHP & JavaScript.
        </p>
        <p>
            <strong>Dibuat dengan ❤️ untuk kemudahan manajemen tugas Anda</strong>
        </p>
        <p style="margin-top: 30px; text-align: center; color: #999; font-size: 0.9em;">
            Last Updated: 2026-02-23 | Version 1.0.0
        </p>
    </div>
</body>
</html>
