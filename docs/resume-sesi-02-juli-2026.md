# Resume Sesi — 2 Juli 2026

## OG Image WhatsApp Fix & Bug Repairs

---

## 1. OG Image WhatsApp Tidak Muncul

### Masalah
Saat link undangan (https://aufilla.online/lutfi-shella) dibagikan ke WhatsApp, title & description muncul tapi gambar (og:image) tidak tampil.

### Diagnosis (via SSH Hostinger)
- GD extension aktif ✅
- `APP_URL` sudah `https://aufilla.online/` ✅
- Storage symlink `public/storage → storage/app/public` benar ✅
- Cache-control, content-type, status code semua OK ✅
- **Kesimpulan**: server 100% sehat, masalah di WhatsApp cache + konfigurasi minor

### Perbaikan

| # | File | Perubahan | Kenapa |
|---|------|-----------|--------|
| 1 | `.env` (Hostinger) | `APP_ENV=local` → `production`, `APP_DEBUG=true` → `false` | Debug mode aktif di production, berbahaya |
| 2 | `app/Providers/AppServiceProvider.php` | Hapus kondisi `if ( !== 'local')` | `forceScheme('https')` harus unconditional |
| 3 | `app/Http/Controllers/Client/OgImageController.php` | Hapus `with('akad')` — relasi tidak ada di model | Error 500 tiap akses `/og-image/{id}.jpg` |
| 4 | Semua 14 theme `index.blade.php` | `og:image` dari `asset('storage/...')` → `route('og-image', ['id' => $id])` | Image 800x600 via Laravel, dimensi cocok meta, bypass potential symlink issues |
| 5 | `public/.htaccess` | Tambah bypass mod_security + cache header | Defense-in-depth untuk crawler |

### Flow OG Image Baru
```
WhatsApp crawler → halaman undangan → og:image: https://aufilla.online/og-image/1.jpg
                                                   ↓
                                          OgImageController
                                                   ↓
                                    cover_img → crop 800x600 (GD)
                                                   ↓
                                    cache di storage/app/public/og/
                                                   ↓
                                    response()->file() — HTTP 200, image/jpeg
```

---

## 2. Error 500 Tema Soraya (Carbon Date Parse)

### Masalah
Ganti tema `lutfi-shella` ke soraya-pilot → Error 500:
```
Carbon\Exceptions\InvalidFormatException
Could not parse '12 Desember 2023'
```

### Akar Masalah
- Kolom `ceritas.tanggal` adalah **string** (varchar) — isi bebas
- Input form menerima teks: "14 Februari 2023" atau "Tahun 2021"
- 13 tema Aufilla pakai `{{ $cerita->tanggal }}` (output mentah) → aman
- Soraya-pilot pakai `Carbon::parse($cerita->tanggal)->translatedFormat(...)` → crash

### Perbaikan
`resources/views/themes/soraya-pilot/index.blade.php`:375
```blade
@php
  $tanggalTampil = $cerita->tanggal;
  try {
    $tanggalTampil = \Carbon\Carbon::parse($cerita->tanggal)->translatedFormat('d F Y');
  } catch (\Exception $e) {}
@endphp
<p>{{ $tanggalTampil }}</p>
```

---

## 3. Fitur Edit Cerita (Tambahan)

### Masalah
Di halaman `client/cerita` hanya ada tombol tambah & hapus, tidak ada edit.

### Perbaikan

| Komponen | File | Detail |
|----------|------|--------|
| Route | `routes/web.php:74` | `PUT /client/cerita/{id}` → `FeatureController@updateCerita` |
| Controller | `FeatureController.php:92-113` | Method `updateCerita()` — validasi + update DB + return JSON |
| Tombol Edit | `cerita.blade.php:39-46` | Icon pensil di pojok kanan card, muncul hover |
| Modal Edit | `cerita.blade.php:108-170` | Modal 3 field (tanggal, judul, isi) — pre-filled |
| JS | `cerita.blade.php` | `editCerita()`: baca data card → isi form |
| JS | `cerita.blade.php` | `updateCerita()`: AJAX PUT → replace card tanpa reload |
| JS | `cerita.blade.php` | `buatCardCerita()`: helper HTML card (shared add/edit) |

### Flow Edit
```
User hover card → klik ✏️ → modal terbuka (data terisi)
    → ubah → klik Simpan Perubahan
    → AJAX PUT /client/cerita/{id}
    → card di-replace tanpa reload
```

---

## 4. Sinkronisasi Local ↔ Server

Semua file sudah identik (MD5 match), kecuali `.env`:

| File | Status |
|------|--------|
| `.env` | ⏭️ Local = `local`, Server = `production` (sengaja beda) |
| `app/Providers/AppServiceProvider.php` | ✅ |
| `app/Http/Controllers/Client/OgImageController.php` | ✅ |
| `public/.htaccess` | ✅ |
| 14 theme `index.blade.php` | ✅ |
| `routes/web.php` | ✅ |
| `app/Http/Controllers/Client/FeatureController.php` | ✅ |
| `resources/views/client/cerita.blade.php` | ✅ |

---

## Files Changed (8 total)
1. `.env` (server only)
2. `app/Providers/AppServiceProvider.php`
3. `app/Http/Controllers/Client/OgImageController.php`
4. `routes/web.php`
5. `app/Http/Controllers/Client/FeatureController.php`
6. `public/.htaccess`
7. `resources/views/themes/*/index.blade.php` (14 files)
8. `resources/views/themes/soraya-pilot/index.blade.php`
9. `resources/views/client/cerita.blade.php`
