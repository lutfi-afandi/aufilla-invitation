# ATURAN DESAIN (DESIGN RULES) - WEDDING PLATFORM

## 1. Arsitektur Template Blade (Strict Inheritance)

Proyek ini menggunakan metode **Template Inheritance** murni untuk menjaga konsistensi struktur dan mempermudah perawatan kode. 

- **Dilarang Keras** menggunakan komponen berbasis slot (`<x-slot>`, `<x-layout>`, atau anonymous components bawaan Laravel modern) untuk layout halaman utama.
- **Wajib** menggunakan kombinasi direktif `@extends`, `@section`, `@yield`, dan `@include`.

### Contoh Implementasi Base Layout (`layouts/app.blade.php`):
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Undangan Digital')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="[https://code.jquery.com/jquery-3.7.1.min.js](https://code.jquery.com/jquery-3.7.1.min.js)"></script>
</head>
<body class="bg-slate-50 antialiased">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>