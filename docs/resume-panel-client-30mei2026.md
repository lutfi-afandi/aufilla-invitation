# Resume Pekerjaan — Aufilla Invitation (Panel Client + Public)

> **Tanggal Sesi:** 30 Mei 2026  
> **Cakupan:** Panel Client, Halaman Publik Undangan, Routing, SEO, QR Code, Keamanan Hak Akses

---

## 1. Refactoring Sistem Buku Tamu & QR Code

### Masalah Awal
Kode QR tamu di-generate secara **tidak aman**: hanya menggabungkan `id` tamu dengan string sederhana (misal: `TAMU-5`). Ini mudah ditebak dan dipalsukan.

### Solusi yang Diterapkan

#### a. Migrasi Database: Kolom `kode_qr`
- **File:** [2026_05_30_140635_add_kode_qr_to_tamus_table.php](file:///c:/laragon/www/self-project/my-undangan-v2/database/migrations/2026_05_30_140635_add_kode_qr_to_tamus_table.php)
- Menambahkan kolom `kode_qr` (string, unique, nullable) ke tabel `tamus`.
- Backfill: Semua tamu lama yang belum punya kode otomatis dibuatkan `Str::random(10)`.

#### b. Auto-Generate Kode QR di Model
- **File:** [Tamu.php](file:///c:/laragon/www/self-project/my-undangan-v2/app/Models/Tamu.php)
- Menggunakan `boot()` event `creating`: setiap tamu baru otomatis mendapat `kode_qr = Str::random(10)` — 10 karakter alfanumerik acak, cukup aman dan tidak terlalu panjang.

#### c. Server-Side QR Generation
- **File:** [PublicInvitationController.php](file:///c:/laragon/www/self-project/my-undangan-v2/app/Http/Controllers/PublicInvitationController.php)
- QR Code di-*generate* di server menggunakan `SimpleSoftwareIO\QrCode` berdasarkan `$tamu->kode_qr`.
- QR hanya muncul jika parameter `?to=NamaTamu` cocok dengan data di database.

#### d. Tombol QR Melayang + Modal di Halaman Publik
- **File:** [index.blade.php](file:///c:/laragon/www/self-project/my-undangan-v2/resources/views/themes/aufilla-green/index.blade.php) (sekitar baris 707-743)
- Tombol bulat hijau gelap melayang di pojok kanan bawah (di atas tombol musik).
- Saat diklik, membuka modal overlay berisi:
  - QR Code SVG
  - Nama tamu
  - Kode QR (teks)
  - Tombol "Simpan Tiket (PNG)" — download on-the-fly via API eksternal tanpa beban storage server.
- **100% inline styles** — tidak bergantung pada class Tailwind yang belum ter-compile di `tailwind.css` statis tema.

#### e. Download QR On-The-Fly (Tanpa Beban Server)
- Menggunakan `https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={kode_qr}` sebagai sumber download PNG.
- Tidak menyimpan file apapun di server/storage — gambar di-generate langsung di browser tamu.

---

## 2. Perbaikan Routing — Fix ERR_TOO_MANY_REDIRECTS

### Masalah
Route publik `/{slug}` awalnya berada **di dalam** grup middleware `auth`. Akibatnya, tamu asli (yang tidak login) mengalami *infinite redirect loop* ke halaman `/login` saat membuka link undangan dari WhatsApp.

### Solusi
- **File:** [web.php](file:///c:/laragon/www/self-project/my-undangan-v2/routes/web.php) (baris 77-79)
- Memindahkan route publik ke **paling bawah** file, setelah `require auth.php`:
  ```php
  Route::post('/{slug}/ucapan', [PublicInvitationController::class, 'storeUcapan']);
  Route::get('/{slug}', [PublicInvitationController::class, 'show']);
  ```
- Ini memastikan route publik tidak terkena middleware `auth`, sekaligus menjadi catch-all terakhir agar tidak menimpa route lain.

---

## 3. SEO & Meta Tags — Halaman Publik

### Sebelum
Hanya ada `<title>Undangan Pernikahan</title>` generik tanpa meta description atau OpenGraph.

### Sesudah
- **File:** [index.blade.php](file:///c:/laragon/www/self-project/my-undangan-v2/resources/views/themes/aufilla-green/index.blade.php) (baris 48-68)
- Meta tags dinamis yang di-generate dari data undangan:

| Meta Tag | Konten |
|---|---|
| `<title>` | "The Wedding of [Wanita] & [Pria]" |
| `og:title` | Sama dengan title |
| `og:description` | "Kami mengundang Anda untuk hadir di acara pernikahan kami pada [Tanggal]." |
| `og:image` | Foto hero/cover undangan |
| `og:url` | URL halaman saat ini |
| `twitter:card` | `summary_large_image` |
| `twitter:title/description/image` | Sama dengan OG |

- **Efek:** Saat link undangan dibagikan via WhatsApp/Facebook/Twitter, akan muncul preview card yang cantik dengan gambar dan deskripsi.

---

## 4. Favicon

### Sebelum
File `public/favicon.ico` kosong (0 bytes).

### Sesudah
- Menggunakan logo yang sudah ada: `public/assets/img/logo-icon.png`.
- Diterapkan ke **3 layout**:

| File | Keterangan |
|---|---|
| [index.blade.php](file:///c:/laragon/www/self-project/my-undangan-v2/resources/views/themes/aufilla-green/index.blade.php) | Halaman publik undangan |
| [client.blade.php](file:///c:/laragon/www/self-project/my-undangan-v2/resources/views/layouts/client.blade.php) | Layout panel client |
| [app.blade.php](file:///c:/laragon/www/self-project/my-undangan-v2/resources/views/layouts/app.blade.php) | Layout utama (auth/admin) |

---

## 5. Keamanan: Hak Akses Status Undangan

### Masalah
Klien bisa mengubah status undangan sendiri (Draft → Aktif → Nonaktif) melalui dropdown di halaman Pengaturan. Ini berbahaya karena status terkait langsung dengan sistem bisnis/pembayaran admin.

### Solusi

#### a. Backend (Controller)
- **File:** [InvitationController.php](file:///c:/laragon/www/self-project/my-undangan-v2/app/Http/Controllers/Client/InvitationController.php) (method `updateSettings`)
- Menghapus `'status' => 'required|in:...'` dari validasi.
- Menghapus `'status' => $request->status` dari `$updateData`.
- Klien tetap bisa update: musik, toggle galeri/cerita/kado. Tapi **BUKAN** status.

#### b. Frontend (View)
- **File:** [pengaturan.blade.php](file:///c:/laragon/www/self-project/my-undangan-v2/resources/views/client/pengaturan.blade.php) (baris 38-42)
- Mengganti `<select>` dropdown menjadi `<div>` read-only dengan `cursor-not-allowed`.
- Menambahkan keterangan: `*Status mutlak hak akses Admin.`

---

## 6. Bug Fix: Syntax Error (ParseError) di Blade

### Masalah
Saat memindahkan blok QR, tag `@if` tertinggal tanpa pasangan `@endif`, menyebabkan:
```
ParseError: syntax error, unexpected token "endif"
```

### Solusi
Membersihkan sisa tag `@if(isset($tamu) && isset($qrCode))` yang tertinggal di baris akhir file tanpa pasangan `@endif`.

---

## 7. Ringkasan Seluruh File yang Dimodifikasi

| # | File | Perubahan |
|---|---|---|
| 1 | `database/migrations/2026_05_30_*_add_kode_qr.php` | **[NEW]** Kolom `kode_qr` di tabel `tamus` |
| 2 | `app/Models/Tamu.php` | Auto-generate `kode_qr` via boot event |
| 3 | `app/Http/Controllers/PublicInvitationController.php` | Lookup tamu by nama, generate QR server-side |
| 4 | `app/Http/Controllers/Client/InvitationController.php` | Hapus `status` dari `updateSettings()` |
| 5 | `resources/views/themes/aufilla-green/index.blade.php` | QR floating button + modal (inline styles), SEO meta, favicon |
| 6 | `resources/views/client/pengaturan.blade.php` | Status menjadi read-only |
| 7 | `resources/views/layouts/client.blade.php` | Favicon |
| 8 | `resources/views/layouts/app.blade.php` | Favicon |
| 9 | `routes/web.php` | Pindah route publik ke luar auth middleware |

---

## 8. Status Panel Client — Assessment

Panel client saat ini sudah **feature-complete** untuk MVP:

| Modul | Status | Catatan |
|---|---|---|
| Dashboard | ✅ | Ringkasan undangan |
| Pengantin | ✅ | CRUD data mempelai + foto |
| Acara | ✅ | Akad & Resepsi + Google Maps |
| Tamu | ✅ | CRUD + Import/Export Excel + QR + WhatsApp link |
| Galeri | ✅ | Upload foto |
| Cerita | ✅ | Timeline love story |
| Kado | ✅ | Dompet digital + alamat pengiriman |
| Pengaturan | ✅ | Musik, toggle fitur, tema (read-only), status (read-only) |
| Halaman Publik | ✅ | Tema aufilla-green + SEO + QR floating |

> [!NOTE]
> Tidak ada saran kritis untuk panel client. Seluruh modul sudah berjalan. Langkah selanjutnya adalah membangun **Panel Admin**.
