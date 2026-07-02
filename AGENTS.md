# AGENTS.md — Theme Generation Manifesto (Aufilla & Soraya)

Baca ini SETIAP KALI sebelum membuat/meng-clone tema baru. Dokumen ini mencegah masalah kontras, kerataan visual, dan kesalahan role warna yang pernah terjadi sebelumnya.

> **PENTING:** Ada **2 keluarga desain** yang BERBEDA TOTAL arsitekturnya:
> - **Aufilla** → Split-screen (panel kiri + kanan), Tailwind palette inline, font lokal/sistem.
> - **Soraya** → Single-column scrollable, editorial/magazine style, Google Fonts (Playfair Display, Great Vibes, Montserrat).
>
> JANGAN PERNAH meng-clone Aufilla dari Soraya atau sebaliknya. Gunakan basis yang benar.

---

## 1. Flow Pembuatan Tema Baru

1. **Clone** dari tema yang struktur cahaya/gelapnya paling cocok (`aufilla-maroon` = dark cover/light right, `aufilla-white` = all light).
2. **Ganti Tailwind palette** (colors) di `index.blade.php` — setiap palette WAJIB punya gradasi 50–950 yang lengkap.
3. **Ganti nama kelas** Tailwind secara massal (primary → primary baru, accent → accent baru, bg → bg baru).
4. **Ganti inline hex colors** (rgba, borders, backgrounds) satu per satu — jangan dilewat.
5. **Audit kontras** — gunakan checklist di bawah. Ini langkah paling krusial.
6. **Cek setiap section**: cover, hero, quote, couple, event, story, gallery, gift, rsvp, footer, loading, floating controls, QR modal.

---

## 2. Color Role Convention (WAJIB)

Setiap tema punya 3 kelompok warna:

| Role | Contoh nama | Fungsi |
|------|-----------|--------|
| **Primary** | maroon, teal, blush, onyx | Warna utama tema. Untuk heading H2, tombol CTA, nama pasangan, elemen IMPORTANT saja. |
| **Neutral** | gold → silver, champagne, copper | Warna pendamping. Untuk subtitle, border, garis, icon, frame, divider — semua elemen DEKORATIF. |
| **Background** | cream → ice/pearl, white, ivory | Warna latar. Untuk section bg, card bg, canvas. |

### Aturan penggunaan di setiap konteks:

#### Light section (bg terang)
| Elemen | Warna | Contoh |
|--------|-------|--------|
| H2 heading | Primary 800/900 | `text-maroon-800` |
| Section subtitle | Neutral 600 | `text-gold-600` |
| Section underline | Neutral 400 | `bg-gold-400` |
| Nama pasangan | Primary 800 | `text-maroon-800` |
| Tombol CTA | Primary 800 | `bg-maroon-800 text-white` |
| Icon dekoratif | Neutral 500/600 | `text-gold-500` |
| Border dekoratif | Neutral 400/20–30% | `border-gold-400/20` |
| Body text | Stone 600 | `text-stone-600` |
| Label sekunder | Neutral 600 | `text-gold-600` |
| Card bg | White | `bg-white` |

#### Dark section / overlay (bg gelap)
| Elemen | Warna | Contoh |
|--------|-------|--------|
| Teks utama | White | `text-white` |
| Teks sekunder | Primary/Light 100–200 | `text-maroon-100` |
| Aksen dekoratif | Neutral 200–300 | `text-gold-200` |
| Icon dekoratif | Primary 200–300 | `text-maroon-200` |
| Border | Primary 400/15–20% | `border-maroon-400/15` |
| **JANGAN PAKAI** | Neutral/Accent 500 sbg teks | ❌ `text-gold-500` di `bg-maroon-800` |

### ⚠️ Golden Rule: JANGAN PERNAH menaruh `{accent}-500` sbg teks di atas `{primary}-800/900` sbg background. Kontrasnya selalu kurang.

---

## 3. Checklist Audit Kontras (Cek Setiap Tema Baru)

Setelah replace warna selesai, audit SATU PER SATU:

### Cover / Hero Overlay
- [ ] Overlay opacity: maksimal 0.55–0.60 di bagian tengah. Foto harus tetap terlihat.
- [ ] Gradient: darker di tepi (0.65–0.70), lighter di tengah (0.40–0.50).
- [ ] `&` symbol pakai light variant (100–200), jangan 500.

### Dark Sections (loading, cover overlay, left panel, footer, floating controls)
- [ ] Semua teks: white atau 100–200, JANGAN 500.
- [ ] Tombol CTA di atas overlay: bg putih/terang + teks primary-800 (contrast maksimal).
- [ ] Countdown numbers: `text-white` + `drop-shadow-sm` untuk legibility.
- [ ] Countdown labels: neutral-100/200, bukan warna asli.
- [ ] Countdown box borders: primary-400/15, jangan neutral-500/30.

### Light Sections (right panel)
- [ ] Subtitle section: neutral-600 (bukan primary-500).
- [ ] Underline: neutral-400 (bukan primary-500).
- [ ] Border dekoratif: neutral-400/20 (bukan primary-500/20).
- [ ] Frame foto: neutral-400 (bukan primary-500).
- [ ] Label "Mempelai Pria/Wanita": neutral-600 (bukan primary-600).
- [ ] Ikon event (calendar, clock, map): neutral-600 (bukan primary-600).
- [ ] Icon container bg: neutral-50 (bukan primary-50).
- [ ] Divider heart: neutral-500 (bukan primary-500).

### CTA Buttons
- [ ] Primary-800 bg + white text untuk semua tombol aksi utama (maps, submit RSVP).
- [ ] Hover state: brightness/scale effect.

### Floating Controls
- [ ] Music button: primary gradient dengan white icon.
- [ ] QR/Back-to-top: primary bg, light icon (200–300).
- [ ] Nav bar: border primary-400/20, active state white atau light variant.

### Section Background Alternation
- [ ] Genap dan ganjil bergantian: ice-50 (white) ↔ ice-100 (light tint).

---

## 4. Palette Quality Standards

Setiap palette WAJIB:

1. **Mid-tones (400–600) harus vibrant** — jangan muted/pucat. Kalau perlu, pakai saturasi lebih tinggi.
2. **Dark base (800) harus cukup gelap** untuk kontras dengan teks putih di atasnya.
3. **Light variants (50–200) harus murni** — tidak bercampur hue lain yang membuatnya kotor.
4. **Gradasi halus** — no abrupt jumps. 50→100→200→300→400→500→600→700→800→900→950.

**Test palette**: cek visual dengan mata — teks 800 di atas bg 50 harus jelas, teks white di atas bg 800 harus kontras.

---

## 5. Yang PERNAH SALAH (Lessons Learned)

Dari pengalaman `aufilla-teal`:

| Masalah | Akar | Solusi |
|---------|------|--------|
| Cover foto tidak keliatan | Overlay opacity 0.85–0.95 | Maks 0.55–0.70 |
| Tampilan datar/monoton | Semua elemen pakai primary-500 (border, icon, subtitle, underline) | Neutral untuk decorative, primary hanya untuk heading/CTA |
| Text kusam di dark section | silver-500 (#8E98A0) di atas teal-800 (#0E5E6B) | Teks di dark bg pake 100–200 atau white |
| Countdown angka tidak terbaca | silver-500 pada teal-800 | white + drop-shadow |
| Button Buka Undangan samar | Silver gradient + dark teal text di atas overlay | White bg + primary-800 text |
| `&` symbol tidak jelas | neutral-500 di dark bg | light primary (200) atau white/70 |

---

## 6. File Referensi

- `resources/views/themes/aufilla-teal/index.blade.php` — contoh implementasi dengan koreksi kontras lengkap
- `resources/views/themes/aufilla-maroon/index.blade.php` — template dasar untuk clone dark theme
- `docs/theme_generation_guide.md` — panduan teknis struktur tema
- `future_themes_suggestions.md` — daftar calon tema dan contoh prompt

---

## 7. Standar Emas Generasi Tema (Mocha Standard)

Berdasarkan perbaikan UI yang diimplementasikan pada tema **Aufilla Mocha (Tema 8)**, setiap pembuatan skrip generasi (`generate_themes_*.php`) untuk tema baru **WAJIB** menyertakan 4 perbaikan (UI Bug Fixes) berikut:

1. **Memperbaiki Typo `inline-self-start`:**
   Mencegah *background* header melebar ke seluruh layar kiri.
   ```php
   $content = str_replace('inline-self-start', 'self-start inline-block', $content);
   ```

2. **Memperbaiki Kotak Transparan yang Kusam (Muddy Boxes):**
   Ganti transparansi warna merah tua/primer menjadi efek *Dark Glassmorphism* universal (`bg-black/40 backdrop-blur-md`) agar bersih dan kontras di atas tema warna apapun.
   ```php
   $content = str_replace('bg-[#5A1F24]/75', 'bg-black/40', $content);
   $content = str_replace('bg-[#5A1F24]/80', 'bg-black/40', $content);
   ```

3. **Gradasi Panel Kiri (Bawah Gelap, Atas Transparan/Clear):**
   Ubah gradasi statis menyamping (`135deg`) menjadi gradasi vertikal (`to top`) dengan nilai *Alpha* (Opacity) atas adalah `0.0` (transparan penuh). Ini menonjolkan foto pasangan di bagian atas. Header "UNDANGAN PERNIKAHAN" harus dipertebal *background*-nya agar tetap terbaca.
   ```php
   $oldLeftGradient = 'linear-gradient(135deg, rgba(61,21,24,0.92) 0%, rgba(90,31,36,0.85) 100%)';
   $newLeftGradient = 'linear-gradient(to top, rgba(\' . hexToRgbNoSpace($config[\'primary_950\']) . \', 0.95) 0%, rgba(\' . hexToRgbNoSpace($config[\'primary_900\']) . \', 0.0) 100%)';
   $content = str_replace($oldLeftGradient, $newLeftGradient, $content);
   
   // Perlindungan kontras untuk header kiri karena bagian atas gradasi sudah transparan
   $content = str_replace('bg-black/10 backdrop-blur-xs p-4 rounded-lg', 'bg-black/50 backdrop-blur-md border border-white/10 shadow-2xl p-5 rounded-xl', $content);
   ```

4. **Navigasi Melayang (*Floating Nav*) & Jarak *Footer*:**
   Pastikan *footer* utama diberi *padding* bawah 32 agar teks "Dibuat dengan dedikasi..." tidak tertutup menu melayang. Ikon navigasi aktif harus menggunakan **Amber-300 Glowing** agar tidak samar.
   ```php
   $content = str_replace('py-20 px-6 bg-[', 'pt-20 pb-32 px-6 bg-[', $content);
   $content = str_replace("addClass('text-gold-400 font-bold scale-110');", "addClass('text-amber-300 font-bold drop-shadow-[0_0_5px_rgba(251,191,36,0.5)] scale-125');", $content);
   $content = str_replace("removeClass('text-gold-400 font-bold scale-110')", "removeClass('text-amber-300 font-bold drop-shadow-[0_0_5px_rgba(251,191,36,0.5)] scale-125')", $content);
   $content = str_replace('text-white hover:text-gold-400', 'text-stone-300 hover:text-amber-300', $content);
   $content = str_replace('hover:text-gold-400', 'hover:text-amber-300', $content);
   ```

---
---

# BAGIAN B: SORAYA THEME FAMILY — Clone Manifesto

Soraya adalah keluarga desain **TERPISAH** dari Aufilla. Arsitekturnya sepenuhnya berbeda. Basis clone WAJIB dari `soraya-pilot`.

---

## S1. Arsitektur Soraya vs Aufilla (PERBEDAAN FUNDAMENTAL)

| Aspek | Aufilla | Soraya |
|-------|---------|--------|
| **Layout** | Split-screen (panel kiri tetap + panel kanan scroll) | Single-column full-width scrollable |
| **Cover** | Panel kiri sebagai cover, tombol di tengah overlay | Full-screen background image + white card bottom-right corner |
| **Tailwind Config** | Palette lengkap 50–950 (primary, neutral, bg) | Palette minimalis `brand` (700/800/900) + `accent` |
| **Fonts** | Font lokal/sistem, `font-serif` default | Google Fonts: `Playfair Display` (serif), `Great Vibes` (script), `Montserrat` (sans) |
| **Couple Section** | Card putih bertingkat, foto bulat/bingkai dekoratif | Blok vertikal berteks putar `.text-vertical` ("THE BRIDE"/"THE GROOM") + foto asimetris |
| **Event Section** | Card dengan ikon + divider dalam panel kanan | Card dengan gambar atas + strip vertikal warna samping |
| **Story Section** | Card putih di panel kanan | Dark background (brand-900) + timeline kiri dengan kartu putih |
| **Ornamen** | Tidak ada (dekorasi via border/shadow saja) | CSS ornaments: `.ornament-dots`, `.ornament-corner`, `.ornament-leaf` |
| **Footer** | Dark bar bottom + branding | Full background image + white card tumpang tindih di kanan bawah |
| **Floating Nav** | Bottom nav bar horizontal dengan ikon section | Tombol individu melayang (musik kiri-bawah, QR kiri-atas, back-to-top kanan-bawah) |

### ⚠️ JANGAN PERNAH mencampur komponen Aufilla ke Soraya atau sebaliknya.

---

## S2. Flow Clone Tema Soraya Baru

1. **Clone** folder `resources/views/themes/soraya-pilot/` → `resources/views/themes/soraya-{nama}/`
2. **Ganti Tailwind config** di `<script>tailwind.config = {...}</script>`:
   - `brand.900`, `brand.800`, `brand.700` → warna baru
   - `accent` → warna aksen baru
3. **Ganti hardcoded rgba di CSS ornament** (ini KRUSIAL, sering terlewat!):
   - `.ornament-dots`: `rgba(74,30,36,...)` → rgb values brand baru
   - `.ornament-corner`: `rgba(74,30,36,...)` → rgb values brand baru
   - `.ornament-leaf`: `rgba(74,30,36,...)` → rgb values brand baru
4. **Ganti background body/section** jika diperlukan:
   - Light mode: `bg-[#F9F9F9]` (default, bisa diganti ke cream/pink/mint)
   - Dark mode: `bg-[#121212]` + ubah semua card `bg-white` → `bg-[#1E1E1E]`
5. **Ganti Google Fonts** (opsional — bisa dipertahankan):
   - URL di `<link href="https://fonts.googleapis.com/css2?family=...">`
   - `fontFamily` di tailwind.config
6. **Audit kontras** menggunakan checklist S3 di bawah.
7. **Daftarkan** tema ke database (`themes` table).

---

## S3. Checklist Audit Kontras Soraya

### Loading Screen
- [ ] Background: `bg-brand-900`
- [ ] Teks & spinner: putih / `white/80`

### Cover Screen
- [ ] Gradient overlay: `from-black/60 via-transparent to-black/60` — foto HARUS terlihat
- [ ] Teks nama: `text-white` + `drop-shadow-lg`
- [ ] White card bottom-right: `bg-white rounded-tl-[80px]`
- [ ] Tombol "Buka Undangan": `bg-brand-800 text-white` (JANGAN transparan)

### Hero Section (Ayat)
- [ ] Background image + overlay `bg-brand-900/60 mix-blend-multiply`
- [ ] Teks ayat: `text-white` + `drop-shadow-md`
- [ ] Gradient bawah: `from-[#F9F9F9] via-transparent to-transparent`

### Light Sections (Couple, Event, Gallery, RSVP)
- [ ] Heading section: `font-script text-brand-800` (Great Vibes)
- [ ] Body text: `text-stone-600` atau `text-stone-700`
- [ ] Vertical strip/label: `bg-brand-800 text-white`
- [ ] Card shadow: `shadow-[0_8px_30px_rgb(0,0,0,0.06)]` (halus, bukan berat)
- [ ] Button CTA: `bg-brand-800 text-white hover:bg-brand-900`

### Dark Sections (Story)
- [ ] Background: `bg-brand-900`
- [ ] Heading: `text-white font-script`
- [ ] Timeline line: `border-white/40`
- [ ] Story card: `bg-white text-stone-800` (kartu putih di atas gelap)
- [ ] Heart icon: `bg-brand-900 border-white`

### Footer
- [ ] Background image + gradient overlay `from-black/80`
- [ ] White card: `bg-white rounded-tl-[80px]` (di KANAN bawah, bukan kiri)
- [ ] Branding: `text-stone-400` di dalam white card
- [ ] Padding bawah cukup agar tidak tertutup floating buttons

### Floating Controls
- [ ] Music: `bg-white text-brand-900` (kiri bawah, z-[60])
- [ ] QR: `bg-brand-800 text-white` (kiri atas dari music, z-[60])
- [ ] Back-to-top: `bg-brand-900 text-white` (kanan bawah, z-[60])

### Ornaments
- [ ] `.ornament-dots`: opacity 0.03–0.05 (HARUS sangat halus)
- [ ] `.ornament-corner`: opacity 0.06–0.10 (garis lengkung tipis)
- [ ] `.ornament-leaf`: opacity 0.03 (nyaris tak terlihat)

---

## S4. Color Role Convention Soraya

Soraya menggunakan sistem warna yang **lebih sederhana** dari Aufilla:

| Role | Nama | Fungsi |
|------|------|--------|
| **Brand** | brand-700/800/900 | Warna utama. Untuk heading, CTA, vertical strips, loading screen, dark sections |
| **Accent** | accent | Warna dekoratif (hanya dipakai minimal, misal ikon quote) |
| **Stone** | stone-400/500/600/700 | Teks body, label, timestamp |
| **White** | bg-white, text-white | Card background, teks di dark sections |
| **Background** | bg-[#F9F9F9] | Canvas utama body & section bergantian |

### ⚠️ Golden Rule Soraya:
- **brand-50** dipakai untuk badge background (avatar inisial, icon container). Pastikan palette brand punya shade 50 jika dibutuhkan, atau gunakan `bg-[brand-900]/5` sebagai fallback.
- **JANGAN** membuat card berwarna brand di atas background brand. Kontrasnya nihil.

---

## S5. Backend Variable Mapping (KRUSIAL!)

Variabel yang dikirim dari `PublicInvitationController` ke view Soraya:

| Variabel View | Kolom/Relasi | Catatan |
|---------------|-------------|---------|
| `$invitation->pria_nama` | `pria_nama` | Nama panggilan |
| `$invitation->pria_nama_lengkap` | `pria_nama_lengkap` | Nama lengkap |
| `$invitation->wanita_foto` | `wanita_foto` | Path di storage |
| `$invitation->cover_img` | `cover_img` | Path di storage |
| `$invitation->music_file` | `music_file` | Path audio (BUKAN `music_path`!) |
| `$invitation->alamat_kado` | `alamat_kado` | Alamat kirim kado fisik |
| `$galeris` | Collection of `Galeri` | Gunakan `$galeri->image_path` (BUKAN `file_path`!) |
| `$wishes` | Collection of `Ucapan` | Gunakan `$wish->kehadiran` (BUKAN `is_attending`!) |
| `$kados` | Collection of `Kado` | Gunakan `$kado->nomor_rekening` & `$kado->atas_nama` |
| `$tamu` | `Tamu` model | `$tamu->nama_tamu`, `$tamu->kode_qr` |
| `$qrCode` | Generated QR SVG | Render via `{!! $qrCode !!}` |
| `$akad` / `$resepsi` | `Acara` model | `->tgl_acara`, `->waktu_mulai`, `->tempat`, `->alamat` |

### ⚠️ Gallery Path Logic (Anti-Bug):
```blade
@php
  $galUrl = str_starts_with($galeri->image_path, 'assets/')
    ? asset($galeri->image_path)
    : asset('storage/' . $galeri->image_path);
@endphp
```

### ⚠️ Audio Fallback (Anti-NotSupportedError):
```blade
<audio id="bg-music" loop preload="auto">
  @if($invitation->music_file)
  <source src="{{ asset('storage/' . $invitation->music_file) }}" type="audio/mpeg">
  @else
  <source src="{{ asset('assets/default/default-music.mp3') }}" type="audio/mpeg">
  @endif
</audio>
```

---

## S6. Lessons Learned dari Soraya Pilot

| Masalah | Akar | Solusi |
|---------|------|--------|
| Loading screen stuck | Tidak ada JS untuk hide loading screen | Tambahkan `$(window).on('load')` + fallback `setTimeout(2000)` |
| Galeri kosong | Variabel `file_path` salah (harusnya `image_path`) | Gunakan mapping S5 di atas |
| Musik error `NotSupportedError` | `<audio src="">` kosong | Gunakan `<source>` dengan `@if/@else` fallback |
| QR Modal tidak muncul | Query DB langsung di view, data preview tidak masuk | Gunakan `$tamu ?? request('to')` fallback |
| Wishes tidak tampil | Variabel `$ucapans` salah (harusnya `$wishes`) | Gunakan mapping S5 di atas |
| Kado A.N kosong | Variabel `nama_pemilik` salah (harusnya `atas_nama`) | Gunakan mapping S5 di atas |
| Footer bertumpuk tombol melayang | White card di kiri bawah, bertabrakan dgn floating music/QR | Pindahkan card ke **kanan bawah** (`items-end`, `rounded-tl-[80px]`) |
| Section terlalu banyak whitespace | Tidak ada ornamen | Tambahkan `.ornament-dots`, `.ornament-corner`, `.ornament-leaf` |

---

## S7. File Referensi Soraya

- `resources/views/themes/soraya-pilot/index.blade.php` — **SATU-SATUNYA** basis clone untuk semua tema Soraya
- `future_soraya_themes.md` — daftar calon tema Soraya dan contoh prompt clone
