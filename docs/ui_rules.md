# Aufilla UI/UX & Build Rules
**Wajib dibaca sebelum memodifikasi tampilan / view (Landing Page, Admin, Client, Theme).**

Dokumen ini disusun untuk mencegah terulangnya insiden UI yang hancur, *styles* yang bocor (*leaking*), atau sistem *build* CSS yang saling tabrakan.

## 1. Aturan Build System (Tailwind CSS)

### ⛔ DILARANG MENGGUNAKAN TAILWIND V4 PLUGIN (`@tailwindcss/vite`)
- Proyek ini menggunakan **Tailwind v3** lewat `postcss.config.js`. 
- Jangan pernah menginstal atau mengaktifkan `@tailwindcss/vite` di `package.json` atau `vite.config.js`.
- **Alasan:** Tailwind v4 tidak membaca `tailwind.config.js` sama sekali, sehingga semua *custom color* (`brand-dark`, `brand-accent`, dll) akan gagal dirender, dan hasil desain akan rusak/berantakan.

### ✅ Wajib menggunakan `tailwind.config.js`
- Semua warna custom, jenis font, dan konfigurasi kustom HARUS diletakkan di dalam `tailwind.config.js` pada blok `theme.extend`.
- Jangan menggunakan nilai *arbitrary* secara berlebihan di class HTML jika warna tersebut adalah warna brand (contoh: JANGAN pakai `bg-[#0a2214]`, gunakan `bg-brand-dark`).

## 2. Aturan Brand Tokens (Palet Warna)

Aplikasi memiliki dua *scope* desain utama yang terpisah di `tailwind.config.js`. Gunakan token ini:

### Client / Landing Page (Wedding / Elegant Theme)
- `brand-dark` (`#0a2214`): Hijau gelap, digunakan untuk navbar utama, footer, teks primer, judul (serif).
- `brand-medium` (`#143521`): Gradient pendamping hijau gelap.
- `brand-light` (`#235235`): Hover state hijau.
- `brand-accent` (`#c5a880`): Champagne Gold, digunakan untuk logo, border sorotan, icon, dan fitur premium.
- `brand-bg` (`#fdfbf7`): Soft Off-white / Krem terang, digunakan sebagai warna dasar background halaman (*body*).

### Panel Admin (SaaS Modern Theme)
- `admin-dark` (`#0f172a`), `admin-medium` (`#1e293b`), `admin-accent` (`#818cf8`), `admin-bg` (`#f8fafc`), dll.

> **PENTING:** Jangan campur adukkan token admin ke halaman klien/landing page, begitu pula sebaliknya!

## 3. Aturan Zero CDN (Mutlak)

- **DILARANG KERAS** menggunakan tag `<link>` ke Google Fonts (`fonts.bunny.net`, `fonts.googleapis.com`) atau `<script>` ke jQuery/CDN eksternal.
- Aset (JS/CSS) harus dilayani lewat `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
- Font dan JS library tambahan (seperti Alpine.js atau jQuery jika sangat butuh) **wajib diinstal via NPM** dan diimpor melalui file `resources/js/app.js` atau `app.css`.

## 4. Animasi & Interaktivitas

- **DILARANG MENGGUNAKAN PUSTAKA EKSTERNAL (Contoh: AOS CDN)** untuk animasi gulir biasa.
- Gunakan Vanilla JS `IntersectionObserver` (seperti yang ada di `landing/index.blade.php`) dan Tailwind *utility classes* (`transition-all`, `opacity-0`, `translate-y-*`) untuk efek memudar (*fade-in*).

## 5. Isolasi Desain Halaman

- **JANGAN PERNAH** menambahkan blok `<style>` dengan tag selektor mentah (seperti `body { ... }` atau `:root { ... }`) langsung di dalam file `.blade.php`. Ini akan menimpa CSS halaman lain karena mereka di-bundle dalam satu aplikasi SPA/Vite yang sama.
- Jika butuh CSS kustom (sangat tidak disarankan, gunakan Tailwind), maka bungkus dalam class *scoped* yang spesifik (misal: `.lp-reveal { ... }`).
