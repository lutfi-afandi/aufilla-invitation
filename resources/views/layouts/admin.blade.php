<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — Aufilla</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="{{ asset('assets/css/bunny-inter-admin.css') }}" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <style>
        /* Fix: SweetAlert2 menambah height:auto dan padding ke html/body yang merusak layout flex h-screen */
        html.swal2-shown,
        body.swal2-shown,
        html.swal2-height-auto,
        body.swal2-height-auto {
            height: 100% !important;
            overflow: hidden !important;
            padding-right: 0 !important;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-admin-bg flex h-screen overflow-hidden" style="font-family: 'Inter', sans-serif;">
    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 z-20 lg:hidden hidden backdrop-blur-sm transition-all" onclick="toggleSidebar()"></div>
    
    @include('partials.admin_sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 bg-admin-bg relative">
        @include('partials.admin_navbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-10 custom-scrollbar">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-4 text-center text-sm text-slate-400 mt-auto">
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'Aufilla Invitation') }} Admin Panel. All rights reserved.</span>
        </footer>
    </div>

    @stack('scripts')
    <script>
        function toggleSidebar() {
            $('#admin-sidebar').toggleClass('-translate-x-full');
            $('#sidebar-backdrop').toggleClass('hidden');
        }
    </script>
</body>
</html>
