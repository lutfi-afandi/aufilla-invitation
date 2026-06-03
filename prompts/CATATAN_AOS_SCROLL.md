# Catatan Perbaikan AOS (Animate On Scroll) pada Kontainer Kustom

## Masalah
Pada desain layout *split-screen* (contoh: tema `aufilla-maroon`), panel kanan (`#right-pane`) menggunakan `overflow-y-auto` untuk pergerakan turun-naik konten (*scroll*), sementara *window* utama pada layar tidak di-scroll sama sekali. 

Secara *default*, pustaka AOS mendeteksi event `scroll` pada `window`. Karena *window* utama tidak bergeser, elemen-elemen di dalam panel kanan yang posisinya berada di bawah tidak akan pernah dideteksi oleh AOS. Akibatnya, elemen tersebut tidak pernah mendapat tambahan kelas `.aos-animate` dan selamanya tidak muncul (terjebak dalam `opacity: 0`).

## Solusi Gagal (Yang Harus Dihindari)
Sempat dicoba mematikan sensor AOS pada layar desktop dengan pengaturan:
```javascript
AOS.init({ disable: true });
```
**Mengapa ini salah?**
Ketika `disable: true` dipanggil, pustaka AOS secara agresif **membersihkan dan menghapus total** atribut `data-aos`, `data-aos-duration`, dsb. dari *DOM*. Akibatnya:
1. CSS bawaan AOS yang berfungsi untuk mempersiapkan/menyembunyikan elemen (`opacity: 0`) menjadi tidak aktif.
2. Semua elemen muncul paksa sejak awal tanpa ada transisi animasi.
3. Skrip pelatuk pengganti (seperti *Intersection Observer*) tidak dapat menemukan elemen target karena `data-aos` nya sudah lenyap.

## Solusi Benar
1. **Biarkan `AOS.init()` berjalan normal** dengan konfigurasi standar, TANPA `disable: true`.
2. Dengan berjalannya AOS, ia akan membubuhkan atribut wajib dan kelas `.aos-init` ke elemen HTML agar semua elemen bersiap untuk transisi (disembunyikan terlebih dahulu).
3. **Buat `IntersectionObserver` kustom** yang ditargetkan (di-*root*) ke kontainer panel kanan (`#right-pane`).
4. Ketika observer kustom mendeteksi elemen masuk (intersecting) di dalam panel tersebut, tambahkan kelas `aos-animate` secara manual ke target tersebut.

### Implementasi Kode:
```javascript
// 1. Inisialisasi AOS normal (mempertahankan class dan persiapan elemen)
AOS.init({
    duration: 1000,
    once: true,
    offset: 80
});

// 2. Observer khusus yang mendengarkan kontainer kustom (#right-pane)
const observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
        if (entry.isIntersecting) {
            entry.target.classList.add('aos-animate');
        }
    });
}, {
    root: document.getElementById('right-pane'),
    threshold: 0.15
});

// 3. Daftarkan dan amati seluruh elemen target
document.querySelectorAll('[data-aos]').forEach(function(el) {
    observer.observe(el);
});
```

Dengan pola ini, efek mewah AOS dapat berjalan sangat mulus dan aktif per-scroll di dalam desain panel kustom!
