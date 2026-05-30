<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Klien')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans antialiased text-gray-900 bg-brand-bg flex h-screen overflow-hidden">
    
    @include('partials.client_sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 bg-brand-bg relative">
        @include('partials.client_navbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-10 custom-scrollbar">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-brand-accent/10 py-4 text-center text-sm text-gray-500 mt-auto">
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'Aufilla Invitation') }} Klien. All rights reserved.</span>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
