# 📝 TodoList PowerPuff

Aplikasi To-Do List yang responsif dan ramah pengguna dengan sistem login dan registrasi yang aman.

## ✨ Fitur Utama

- 🔐 **Sistem Login & Registrasi** - Pendaftaran dan login yang mudah dan aman
- 📱 **Responsive Design** - Desain yang bekerja sempurna di desktop, tablet, dan mobile
- 🎨 **Modern UI** - Interface yang soft dan menarik dengan gradien navy yang elegan
- ✅ **Manajemen Tugas** - Tambah, edit, tandai selesai, dan hapus tugas
- 💾 **Data Persist** - Semua data tersimpan aman per user
- 🎭 **User Profile** - Setiap user memiliki tugas mereka sendiri
- 🔑 **Password Hashing** - Password yang aman dengan enkripsi bcrypt

## 🚀 Cara Memulai

### 1. Instalasi

1. Pastikan XAMPP sudah terinstal dan berjalan
2. Copy folder `todolist-powerpuff` ke `F:\xampp\htdocs\`
3. Buat folder `data` di dalam `todolist-powerpuff` dengan permissions `755`

### 2. Akses Aplikasi

Buka browser dan akses:
```
http://localhost/todolist-powerpuff/
```

Anda akan diarahkan ke halaman login secara otomatis.

## 📋 Panduan Penggunaan

### Halaman Login (`/login.php`)
- Masukkan email dan password akun Anda
- Centang "Ingat saya" untuk tetap login
- Klik "Lupa password?" jika lupa password
- Klik "Daftar sekarang" untuk membuat akun baru

### Halaman Registrasi (`/register.php`)
- Isi nama lengkap (minimal 3 karakter)
- Masukkan email yang valid
- Buat password (minimal 6 karakter) untuk keamanan yang lebih baik
- Konfirmasi password Anda
- Klik "Daftar" untuk membuat akun
- Lihat indikator kekuatan password secara real-time

### Dashboard Tugas (`/index.php`)
Setelah login, Anda akan melihat dashboard dengan fitur:

**Tambah Tugas:**
- Ketik deskripsi tugas di form input
- Klik "Tambah" atau tekan Enter

**Kelola Tugas:**
- ✓ Klik tombol centang untuk menandai tugas selesai
- ✕ Klik tombol silang untuk menghapus tugas

**User Profile:**
- Lihat nama dan email Anda di navbar
- Klik "Logout" untuk keluar dari akun

## 🛠️ Struktur File

```
todolist-powerpuff/
├── index.php              # Dashboard utama (memerlukan login)
├── login.php              # Halaman login
├── register.php           # Halaman registrasi
├── forgot-password.php    # Halaman reset password
├── logout.php             # Script logout
├── app.js                 # JavaScript untuk task management
├── auth.js                # JavaScript untuk form validation
├── style.css              # Stylesheet
├── data/                  # Folder untuk menyimpan data
│   ├── users.json         # Data pengguna
│   └── tasks_[user_id].json # Tugas per user
└── README.md              # File dokumentasi ini
```

## 🎨 Design & Warna

Aplikasi menggunakan palet warna yang soft dan modern:

- **Primary Gradient**: #667eea → #764ba2 (purple-blue)
- **Text Dark**: #2c3e50 (navy dark)
- **Background Light**: #f8f9fa (light gray)
- **Border**: #ecf0f1 (very light gray)
- **Success**: #27ae60 (green)
- **Error**: #e74c3c (red)

Desain responsif dengan breakpoint di 480px untuk mobile devices.

## 🔒 Keamanan

- ✓ Password di-hash dengan algoritma bcrypt
- ✓ Session management untuk keamanan login
- ✓ SQL injection prevention (menggunakan JSON storage)
- ✓ XSS prevention dengan htmlspecialchars()
- ✓ CSRF protection untuk forms
- ✓ Per-user data isolation

## 📱 Responsivitas

Semua halaman telah dioptimalkan untuk:

- 📱 Mobile Phones (320px - 480px)
- 📱 Tablets (481px - 768px)
- 💻 Desktop Computers (769px+)

Coba buka aplikasi di berbagai ukuran layar untuk melihat responsivitasnya!

## 🐛 Troubleshooting

### "Halaman tidak ditemukan"
- Pastikan folder berada di `F:\xampp\htdocs\todolist-powerpuff`
- Akses melalui `http://localhost/todolist-powerpuff/`

### "Folder data tidak ada"
- Aplikasi akan otomatis membuat folder `data` saat pertama kali diakses
- Jika error, buat folder `data` secara manual dengan permissions 755

### "Email sudah terdaftar"
- Email harus unik untuk setiap user
- Gunakan email berbeda untuk mendaftar akun baru

### "Password tidak cocok"
- Pastikan password dan konfirmasi password sama persis
- Perhatikan CAPS LOCK
- Password case-sensitive

## 📝 Catatan Developer

### Menyimpan File Data
Aplikasi menggunakan JSON files untuk menyimpan data:
- `data/users.json` - Menyimpan semua user dan password hash
- `data/tasks_[user_id].json` - Menyimpan tugas per user

### Menambah Custom Styling
Edit file `style.css` atau tambahkan style langsung di file PHP.

### Session Variables
Tersedia setelah login:
```php
$_SESSION['user_id']    // Unique user identifier
$_SESSION['user_name']  // Nama user
$_SESSION['user_email'] // Email user
```

## 🌟 Tips Penggunaan

1. **Gunakan Email Real** - Memudahkan recovery jika lupa password
2. **Password Kuat** - Gunakan kombinasi huruf, angka, dan simbol
3. **Refresh Regular** - Data otomatis ter-sync dengan server
4. **Clear Browser Cache** - Jika ada masalah loading

## 📞 Support

Jika menemukan bug atau ada saran fitur baru, silakan dokumentasikan dan resolve sesuai kebutuhan.

## 📄 Lisensi

Aplikasi ini dibuat sebagai project learning untuk TODO list management dengan PHP dan JavaScript.

---

**Dibuat dengan ❤️ untuk kemudahan manajemen tugas Anda**

Version: 1.0.0  
Last Updated: 2026-02-23
