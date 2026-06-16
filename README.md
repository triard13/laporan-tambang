<div align="center">
    <img src="https://ui-avatars.com/api/?name=Laporan+Tambang&background=047857&color=fff&size=128" alt="Logo Laporan Tambang" width="100">
    <h1>Sistem Informasi Manajemen Laporan Tambang</h1>
    <p>Aplikasi web modern berbasis Laravel untuk memonitoring, mencatat, dan memvalidasi operasional serta produksi harian pertambangan secara <i>real-time</i>.</p>
</div>

---

## 🌟 Fitur Utama
- **📊 Dashboard Interaktif**: Visualisasi grafik produksi harian, tren pertumbuhan, diagram distribusi lokasi tambang, serta *Leaderboard Top 5 Operator* paling produktif.
- **📝 Pelaporan Produksi Harian (Hauling)**: Modul untuk operator alat berat (seperti Dump Truck) menginput data ritase, volume material (BCM), pemakaian bahan bakar, hambatan operasional, dan jarak angkut.
- **✅ Verifikasi Multi-Level**: Sistem persetujuan laporan oleh *Supervisor* (Validasi, Revisi, atau Tolak) lengkap dengan catatan (*notes*).
- **🚜 Manajemen Alat Berat & Lokasi**: Pendataan aset alat tambang yang aktif beserta historis ketersediaannya.
- **👥 Manajemen Pengguna (Role Based Access)**: Integrasi akses pengguna yang sangat kuat menggunakan Spatie Permission. Mendukung pendataan NIK/NRP, Jabatan, dan status keaktifan (*Aktif/Non-Aktif*).
- **📑 Ekspor Excel**: Rekapitulasi laporan operasional harian yang dapat diekspor langsung ke format Microsoft Excel berdasarkan filter tanggal dan status.
- **📋 Log Aktivitas (Audit Trail)**: Perekaman setiap tindakan pengguna ke dalam sistem (Create, Update, Delete, Verifikasi) guna menjaga keamanan dan akuntabilitas data.

## 💻 Tech Stack
Sistem ini dibangun menggunakan standar teknologi web modern untuk performa dan keamanan terbaik:
- **Framework**: [Laravel 11.x](https://laravel.com)
- **Frontend**: Blade Templating, [Tailwind CSS](https://tailwindcss.com), Alpine.js
- **Database**: MySQL / MariaDB
- **Authentication**: Laravel Breeze
- **Role Management**: Spatie Laravel-Permission
- **Charts**: Chart.js

## ⚙️ Kebutuhan Sistem (Prerequisites)
Sebelum menjalankan aplikasi, pastikan sistem Anda memiliki:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB Database Server

## 🚀 Panduan Instalasi

1. **Clone repositori ini** atau letakkan source code di dalam folder lokal Anda.
   ```bash
   git clone <url-repo-anda> laporan-tambang
   cd laporan-tambang
   ```

2. **Install Dependensi PHP & Node.js**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file konfigurasi bawaan.
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan atur konfigurasi *database* Anda:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_laporan_tambang
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi & Seeder Database** (Wajib untuk membuat struktur tabel dan akun *default*)
   ```bash
   php artisan migrate --seed
   ```

6. **Kompilasi Aset Frontend (Tailwind)**
   ```bash
   npm run build
   # atau 'npm run dev' untuk mode development
   ```

7. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser pada `http://localhost:8000`.

## 🔐 Kredensial Default (Testing)
Jika Anda menggunakan *seeder* bawaan, berikut adalah daftar akun uji coba yang langsung dapat digunakan:

| Role | Email | Password | Hak Akses |
| --- | --- | --- | --- |
| **Admin** | `admin@tambang.com` | `password` | Manajemen Pengguna, Log, Alat, Lokasi |
| **Supervisor** | `supervisor@tambang.com` | `password` | Verifikasi Laporan, Lihat Dashboard |
| **Operator** | `operator@tambang.com` | `password` | Input Laporan Produksi |

*(Pastikan Anda segera mengubah password setelah login ke sistem).*

---
<div align="center">
    <b>© 2026 Divisi IT Operasional Tambang</b><br>
    <i>Dibuat dengan efisiensi dan keamanan tingkat tinggi.</i>
</div>
