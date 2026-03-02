# 📝 TodoList PowerPuff - Dokumentasi Lengkap

## 🎉 Selamat Datang!

Anda telah berhasil mengunduh **TodoList PowerPuff v1.0** - Aplikasi To-Do List modern dengan sistem login dan registrasi yang aman, responsif, dan user-friendly.

---

## 📦 Apa yang Anda Dapatkan?

### ✨ Fitur Utama:
- 🔐 **Sistem Autentikasi Lengkap** - Login, Registrasi, Forgot Password
- 📱 **Fully Responsive** - Desktop, Tablet, Mobile (semua ukuran layar)
- 🎨 **Design Modern** - Gradien purple-blue (navy) yang soft dan menarik
- ✅ **Manajemen Tugas** - Tambah, edit, tandai selesai, hapus tugas
- 👤 **User-Specific Data** - Setiap user memiliki tugas mereka sendiri
- 🔒 **Keamanan Tingkat Tinggi** - Password hashing dengan Argon2ID
- ⚡ **Zero Dependencies** - Vanilla PHP & JavaScript (tidak perlu Framework)
- 💾 **JSON-Based Storage** - Tidak perlu database SQL

---

## 🚀 Quick Start (5 Menit)

### 1. Ekstrak & Copy File
```
Extract folder todolist-powerpuff
Copy ke: F:\xampp\htdocs\todolist-powerpuff\
```

### 2. Start XAMPP
```
Buka XAMPP Control Panel
Klik START untuk Apache
```

### 3. Akses Aplikasi
```
Buka browser: http://localhost/todolist-powerpuff/
```

### 4. Registrasi & Login
```
1. Klik "Daftar sekarang"
2. Isi form dengan data Anda
3. Login dengan akun baru
4. Mulai kelola tugas!
```

---

## 📁 Struktur Folder & File

```
todolist-powerpuff/
│
├── 📄 index.php                 # Dashboard utama (perlu login)
├── 📄 login.php                 # Halaman login
├── 📄 register.php              # Halaman registrasi
├── 📄 forgot-password.php       # Halaman reset password
├── 📄 logout.php                # Script logout
├── 📄 dashboard.php             # Redirect dashboard
│
├── 🔧 config.php                # Konfigurasi aplikasi
├── 🔧 app.js                    # JavaScript task management
├── 🔧 auth.js                   # JavaScript validation & responsive
├── 🔧 style.css                 # Stylesheet utama
│
├── .htaccess                     # Apache configuration
│
├── 📖 SETUP_GUIDE.php           # Setup guide lengkap (buka di browser)
├── 🔧 SYSTEM_CHECK.php          # System check & verification
├── 📖 README_BARU.md            # Dokumentasi format markdown
└── 📖 DOCUMENTATION.md          # File ini
```

### 📂 Folder Data (Dibuat Otomatis)

```
data/
├── users.json                   # Database pengguna
└── tasks_[user_id].json         # Tugas per user
```

---

## 🎯 Panduan Penggunaan

### 📌 Registrasi (Pertama Kali)

1. Dari halaman login, klik **"Daftar sekarang"**
2. Isi formulir registrasi:
   - **Nama Lengkap**: Minimal 3 karakter
   - **Email**: Format valid (nama@domain.com)
   - **Password**: Minimal 6 karakter
   - **Konfirmasi Password**: Harus sama dengan password
3. Password strength indicator akan menunjukkan kekuatan password:
   - 🔴 Lemah (merah)
   - 🟠 Sedang (orange)
   - 🔵 Kuat (biru)
   - 🟢 Sangat Kuat (hijau)
4. Klik tombol **"Daftar"**
5. Jika berhasil, login dengan akun baru

### 🔑 Login

1. Masukkan **Email** Anda
2. Masukkan **Password** Anda
3. Opsional: Centang "Ingat saya" untuk tetap login
4. Klik **"Login"**

### ✅ Dashboard & Manajemen Tugas

Setelah login, Anda akan melihat dashboard dengan:

**Navbar:**
- Nama aplikasi (📝 TodoList PowerPuff)
- Profil user (nama, email, avatar)
- Tombol logout

**Form Tambah Tugas:**
- Input field untuk deskripsi tugas
- Tombol "Tambah" untuk menambahkan tugas

**Daftar Tugas:**
- ✓ Klik centang untuk tandai selesai
- ✕ Klik silang untuk hapus tugas

### ❓ Lupa Password

1. Klik **"Lupa password?"** di halaman login
2. Masukkan email Anda
3. Instruksi reset akan dikirim (dalam versi real, untuk production)
4. Ikuti instruksi untuk reset password

---

## 🎨 Desain & Styling

### Palet Warna

| Elemen | Warna | Hex Code | Penggunaan |
|--------|-------|----------|-----------|
| Primary Gradient | Purple → Blue | #667eea → #764ba2 | Tombol, background, link |
| Text Dark | Navy | #2c3e50 | Heading, text utama |
| Background Light | Light Gray | #f8f9fa | Background komponen |
| Border | Very Light Gray | #ecf0f1 | Border elemen |
| Success | Green | #27ae60 | Pesan sukses, check |
| Error | Red | #e74c3c | Pesan error, delete |
| Muted | Gray | #7f8c8d | Text helper |

### Responsivitas

Aplikasi dioptimalkan untuk:

| Device | Ukuran | Fitur |
|--------|--------|-------|
| 📱 Mobile | 320-480px | Full width, touch-friendly, optimized font |
| 📱 Tablet | 481-768px | Medium layout, balanced spacing |
| 💻 Desktop | 769px+ | Full features, optimal spacing |

---

## 🔒 Keamanan

Aplikasi ini mengimplementasikan best practices keamanan modern:

### ✓ Fitur Keamanan

- **Password Hashing**: Menggunakan algoritma **Argon2ID** (industri terkuat)
  - Memory cost: 2048
  - Time cost: 4
  - Threads: 3

- **Session Management**: 
  - Secure cookie flags
  - HttpOnly (prevent XSS)
  - SameSite (prevent CSRF)

- **Input Validation**:
  - Client-side validation (JavaScript)
  - Server-side validation (PHP)
  - Email format verification
  - Password strength checking

- **Data Protection**:
  - Per-user data isolation
  - XSS prevention dengan htmlspecialchars()
  - Direct file access protection via .htaccess

- **Apache Security**:
  - Security headers (X-Content-Type-Options, X-Frame-Options, X-XSS-Protection)
  - Directory listing disabled
  - Folder data tidak dapat diakses langsung

---

## 🛠️ Informasi Teknis

### Teknologi

| Aspek | Teknologi |
|-------|-----------|
| Backend | PHP 7.4+ |
| Frontend | HTML5, CSS3, Vanilla JavaScript |
| Database | JSON File Storage |
| Styling | Pure CSS (No Bootstrap/Tailwind) |
| Server | Apache (XAMPP) |
| Bahasa | Bahasa Indonesia |

### Browser Support

- ✓ Chrome/Chromium (latest)
- ✓ Firefox (latest)
- ✓ Safari (latest)
- ✓ Edge (latest)
- ✓ Opera (latest)

### File Sizes

| File | Ukuran |
|------|--------|
| style.css | ~15 KB |
| app.js | ~5 KB |
| auth.js | ~8 KB |
| login.php | ~8 KB |
| register.php | ~10 KB |
| **Total | ~50 KB** |

---

## 📋 API Endpoints (Internal)

Aplikasi menggunakan POST/GET untuk AJAX requests:

### Tasks Management

```php
// Add Task
POST /index.php
Data: action=add&text="Task description"

// Toggle Task (mark as done/undone)
POST /index.php
Data: action=toggle&id="task_id"

// Delete Task
POST /index.php
Data: action=delete&id="task_id"

// Fetch All Tasks
GET /index.php
Headers: X-Requested-With: XMLHttpRequest
```

### Response Format

```json
[
  {
    "id": "unique_id",
    "text": "Task description",
    "completed": false,
    "created_at": 1234567890
  }
]
```

---

## 🐛 Troubleshooting

### Q: Aplikasi tidak ditemukan (404 Error)

**Jawaban:**
1. Periksa path: `F:\xampp\htdocs\todolist-powerpuff\`
2. Akses dengan: `http://localhost/todolist-powerpuff/`
3. Pastikan Apache sudah running

### Q: Folder data tidak ditemukan

**Jawaban:**
1. Aplikasi akan membuat folder `data` otomatis
2. Jika error, buat folder `data` manual
3. Set permissions ke `755`

### Q: Email sudah terdaftar saat registrasi

**Jawaban:**
1. Email harus unik untuk setiap akun
2. Gunakan email berbeda
3. Jika lupa email, gunakan forgot password

### Q: Password tidak cocok

**Jawaban:**
1. Pastikan password dan konfirmasi sama persis
2. Password case-sensitive
3. Perhatikan CAPS LOCK
4. Tidak ada spasi di awal/akhir

### Q: Data tugas tidak tersimpan

**Jawaban:**
1. Periksa koneksi internet
2. Refresh halaman
3. Periksa console browser (F12)
4. Pastikan folder data writable

### Q: Tidak bisa logout

**Jawaban:**
1. Session mungkin corrupt
2. Clear browser cache
3. Close dan open browser kembali
4. Delete browser cookies

---

## 💡 Tips Penggunaan

1. **Gunakan Email Real**: Untuk memudahkan recovery jika lupa password
2. **Password Kuat**: Kombinasikan huruf, angka, dan simbol
3. **Regular Cleanup**: Hapus tugas yang sudah selesai untuk menjaga list tetap rapi
4. **Bookmark URL**: Bookmark halaman aplikasi untuk akses cepat
5. **Cross Device**: Login dari perangkat berbeda, semua data tetap tersinkronisasi
6. **Check Responsive**: Buka di mobile untuk full responsive experience
7. **Use Keyboard**: Tekan Enter setelah mengetik tugas untuk submit

---

## 📞 Support & Help

Jika Anda mengalami masalah:

1. **Baca dokumentasi ini terlebih dahulu**
2. **Buka Setup Guide**: `http://localhost/todolist-powerpuff/SETUP_GUIDE.php`
3. **Check System**: `http://localhost/todolist-powerpuff/SYSTEM_CHECK.php`
4. **Clear Browser Cache** dan coba lagi
5. **Check Browser Console** untuk error details (F12)

---

## 🎓 Untuk Developer

### Customize Colors

Edit di halaman PHP atau `style.css`:

```css
:root {
    --primary: #667eea;
    --primary-dark: #764ba2;
    --text-dark: #2c3e50;
    --border-light: #ecf0f1;
    --bg-light: #f8f9fa;
}
```

### Add Custom Fields

Untuk menambah field baru di registrasi:

1. Edit `register.php` - tambah form field
2. Edit `login.php` - tambah form field
3. Edit `index.php` - update session variables
4. Edit `config.php` - update helper functions

### Extend Functionality

- Tambah fitur kategori tugas
- Tambah priority level
- Tambah due date
- Tambah task sharing
- Tambah task history/timeline

---

## 📝 Version History

### Version 1.0.0 (Current)
- ✓ Complete auth system (login, register, forgot password)
- ✓ Task management (CRUD operations)
- ✓ Responsive design
- ✓ Modern UI with soft navy colors
- ✓ Security best practices
- ✓ Complete documentation

---

## 📄 Lisensi

TodoList PowerPuff v1.0 adalah learning project yang dibuat untuk demonstrasi sistem login dan manajemen data dengan PHP & JavaScript.

**Dibuat dengan ❤️ untuk kemudahan manajemen tugas Anda**

---

## 🎯 Next Steps

1. **Refresh halaman** untuk memastikan semua file termuat
2. **Buka SYSTEM_CHECK.php** untuk verifikasi konfigurasi
3. **Baca SETUP_GUIDE.php** untuk panduan lengkap
4. **Mulai daftar dan login** untuk test aplikasi
5. **Berikan feedback** untuk improvement

---

## 📞 Kontak & Feedback

Jika ada pertanyaan, bug report, atau saran fitur:

- Dokumentasikan dengan detail
- Sertakan screenshot jika diperlukan
- Jelaskan langkah untuk reproduce issue
- Sarankan solusi alternatif

---

**Last Updated**: 2026-02-23  
**Version**: 1.0.0  
**Status**: ✓ Production Ready

Terima kasih telah menggunakan TodoList PowerPuff! 🚀
