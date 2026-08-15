# Panduan Lengkap Upload & Deployment Aplikasi ke Hostinger

Mengunggah (deploy) aplikasi Aufilla Invitation ke layanan *shared hosting* seperti Hostinger (hPanel) membutuhkan beberapa langkah terstruktur agar aman, cepat, dan fitur otomatis berjalan lancar.

---

## 🚀 Ringkasan Perintah Penting (Quick Reference)

| Tujuan / Akses | Perintah Lokal / Server | Catatan |
|---|---|---|
| **Build Frontend Asset** | `npm run build` | Jalankan di PC sebelum push/zip |
| **Clear Cache** | `php artisan optimize:clear` | Dijalankan saat ada perubahan konfigurasi |
| **Migrasi DB Server** | `php artisan migrate --force` | Jalankan via SSH Hostinger saat pertama setup / update DB |
| **Symlink Storage** | `php artisan storage:link` | Menghubungkan foto ke folder public |
| **Tes Check Expired** | `php artisan invitation:check-expired` | Jalankan manual untuk tes status expired & log |
| **Jadwal Cronjob Server** | `* * * * * php /path-to-project/artisan schedule:run >> /dev/null 2>&1` | Dipasang di hPanel Hostinger (Cron Jobs) |

---

## 1. Persiapan di Komputer Lokal (PC Anda)

Sebelum mengunggah, siapkan versi produksi aplikasi Anda:

1. **Kompilasi Asset:** Buka terminal dan jalankan:
   ```bash
   npm run build
   ```
2. **Bersihkan Cache:**
   ```bash
   php artisan optimize:clear
   ```
3. **Kompres (Zip) Folder Proyek (Jika Menggunakan Upload Zip):**
   Buka direktori proyek Anda (`c:\laragon\www\self-project\my-undangan-v2`).
   > [!IMPORTANT]
   > Pastikan Anda **TIDAK** ikut mengompres folder `node_modules` dan `.git` karena ukurannya sangat besar dan tidak dibutuhkan di server.

4. **Export Database:**
   Export database `aufilla_invitation_new` menjadi file `.sql` menggunakan HeidiSQL atau phpMyAdmin lokal.

---

## 2. Persiapan Database di Hostinger

1. Login ke **Hostinger hPanel**.
2. Masuk ke menu **Databases > Management**.
3. Buat database baru dan catat:
   - **MySQL Database Name** (misal: `u123456_undangan_db`)
   - **MySQL Username** (misal: `u123456_lutfi`)
   - **Password**
4. Masuk ke **phpMyAdmin** database tersebut dan klik **Import** untuk mengunggah file `.sql` lokal Anda.

---

## 3. Unggah File (Pilih Salah Satu Metode)

### Metode A: Via GitHub (Sangat Disarankan, Paling Praktis)
1. **Push Kode Terbaru:** Pastikan sudah jalankan `npm run build` dan melakukan `git push` ke GitHub (`branch: main` di `refractor-lutfi` atau `main`).
2. **Setup Git Hostinger:** Masuk ke hPanel > **Advanced > GIT**.
3. **Koneksi Repositori:**
   - URL Repositori: `lutfi-afandi/aufilla-invitation`
   - Branch: `main` / `refractor-lutfi`
4. **Deploy:** Klik **Deploy** / **Auto-Deploy**. Hostinger akan menarik file terbaru ke folder `public_html`.
5. **Install Vendor (Via SSH):** Buka hPanel > **Advanced > SSH Access**, jalankan:
   ```bash
   cd public_html
   composer install --no-dev --optimize-autoloader
   ```

### Metode B: Via File Manager (Upload Zip Manual)
1. Masuk ke hPanel > **Files > File Manager**.
2. Masuk ke `public_html`, upload file `.zip` proyek Anda.
3. Klik kanan file zip > **Extract**. Hapus file zip setelah terekstrak.

---

## 4. Konfigurasi Document Root & .env

### Document Root (Tanpa Memindahkan Folder)
Di hPanel > **Domains / Website Configuration**:
Ubah **Document Root** dari `/public_html` menjadi `/public_html/public`.

*Alternatif jika Document Root tidak bisa diubah:*
Buat file `.htaccess` di dalam `public_html`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Konfigurasi `.env`
Edit file `.env` di `public_html`:
```env
APP_NAME="Aufilla Invitation"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456_undangan_db
DB_USERNAME=u123456_lutfi
DB_PASSWORD=password_database_hostinger
```

---

## 5. Storage Link (Symlink Foto Mempelai & Galeri)

Jalankan perintah ini di SSH Terminal Hostinger:
```bash
cd public_html
php artisan storage:link
```

*Alternatif tanpa SSH:*
Buat file `public_html/public/link.php`:
```php
<?php
$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/../storage/app/public';
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
symlink($targetFolder, $linkFolder);
echo 'Symlink berhasil dibuat!';
```
Buka `https://domain-anda.com/link.php` di browser, lalu **segera hapus** file `link.php`.

---

## 6. Mengatur Cron Job (Sangat Penting untuk Expired Undangan & Log)

Fitur pemeriksaan otomatis `invitation:check-expired` membutuhkan Cron Job agar berjalan setiap menit.

1. Di hPanel Hostinger, buka menu **Advanced > Cron Jobs**.
2. Pilih opsi **Custom**.
3. Di kolom **Command**, masukkan baris ini:
   ```bash
   php /home/uXXXXXXX/domains/domain-anda.com/public_html/artisan schedule:run >> /dev/null 2>&1
   ```
   *(Ganti `uXXXXXXX` dan `domain-anda.com` sesuai path asli hosting Anda di File Manager)*.
4. Pilih waktu eksekusi: **Every Minute** (`* * * * *`).
5. Klik **Save**.

### 🔍 Memantau Apakah Cronjob Berjalan:
- Buka **Dashboard Admin** di website Anda (`https://domain-anda.com/admin/dashboard`).
- Lihat Widget **Status Cronjob & Log Expired**. Widget ini akan menampilkan status aktif, waktu eksekusi terakhir (`executed_at`), dan riwayat undangan mana saja yang otomatis di-kedaluwarsa-kan oleh sistem.
