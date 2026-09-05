<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Resepsionis Panel') — {{ setting('app_name', 'Aufilla') }}</title>
    <!-- Favicon -->
    @if(setting('app_favicon'))
        <link rel="icon" href="{{ asset('storage/' . setting('app_favicon')) }}">
    @else
        <link rel="icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/png">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="{{ asset('assets/css/bunny-inter-admin.css') }}" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <style>
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
<body class="font-sans antialiased text-recept-dark bg-recept-base flex h-screen overflow-hidden selection:bg-recept-primary selection:text-white" style="font-family: 'Inter', sans-serif;">
    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 z-20 lg:hidden hidden backdrop-blur-sm transition-all" onclick="toggleSidebar()"></div>
    
    @include('partials.receptionist_sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 bg-recept-base relative h-screen">
        @include('partials.receptionist_navbar')

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 lg:p-10 custom-scrollbar relative">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        function toggleSidebar() {
            document.getElementById('receptionist-sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-backdrop').classList.toggle('hidden');
        }
    </script>
</body>
</html>
