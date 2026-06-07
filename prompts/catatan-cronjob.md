# Panduan Setup Cron Job (Laravel Scheduler)

Catatan ini dibuat agar Anda tidak lupa bagaimana cara mengaktifkan sistem otomatis (Cron Job) di server produksi/hosting (seperti cPanel, CyberPanel, VPS, dll) untuk menjalankan perintah-perintah latar belakang aplikasi Aufilla.

## Perintah Cron Job yang Dibutuhkan

Untuk menjalankan Laravel Scheduler, Anda hanya perlu menambahkan **SATU** baris Cron Job di server Anda. Baris ini akan berjalan setiap menit dan Laravel yang akan mengatur jadwal spesifik tiap fiturnya (misalnya fitur *Auto-Downgrade Trial* yang sudah kita buat).

Tambahkan baris berikut di pengaturan Cron Job server Anda:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Penjelasan:
- `* * * * *`: Artinya perintah ini dijalankan **setiap menit**.
- `cd /path-to-your-project`: Ganti bagian ini dengan path absolut (lokasi folder) di mana file `artisan` aplikasi Aufilla Anda berada di dalam server. (Contoh cPanel: `cd /home/username/public_html/my-undangan-v2`).
- `php artisan schedule:run`: Perintah utama Laravel untuk mengeksekusi semua jadwal yang terdaftar di `routes/console.php`.
- `>> /dev/null 2>&1`: Membuang *output log* agar server Anda tidak penuh dengan file log *cron* dan tidak mengirimkan email *spam* setiap menit ke admin server.

## Fitur yang Berjalan di Scheduler Saat Ini
Saat ini, scheduler memuat perintah berikut:
1. `php artisan invitation:downgrade-expired-trials` : Mengecek semua undangan berstatus `trial` yang batas waktunya (`trial_habis_at`) telah kedaluwarsa. Sistem akan mencabut paket VIP-nya dan menurunkannya secara paksa menjadi paket **Basic**. (Dapat dilihat di `routes/console.php`).

## Jika Anda Menggunakan Server Lokal (Windows/Laragon)
Jika Anda ingin menguji jalannya Cron Job ini di komputer lokal (Windows), Anda dapat menjalankan perintah berikut di terminal:

```bash
php artisan schedule:work
```
Biarkan terminal tersebut tetap terbuka. Perintah ini akan menyimulasikan sistem *cron* dan berjalan terus di latar belakang selama terminal aktif.

---
**Catatan:** Meskipun Anda lupa mengatur Cron Job ini di server produksi, sistem kita sudah memiliki pelapis ganda (*Lazy Evaluation*) di mana paket akan otomatis turun (*downgrade*) tepat saat link undangan diklik oleh siapa pun. Cron Job ini murni berfungsi agar Database Admin bersih secara *real-time* walau tidak ada yang mengklik link sama sekali.
