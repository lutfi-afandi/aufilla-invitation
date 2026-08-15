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

    <!-- DataTables CSS & JS (Local Assets) -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <style>
        /* Fix: SweetAlert2 & Backdrop Z-Index Fix */
        .swal2-container {
            z-index: 99999 !important;
        }

        html.swal2-shown,
        body.swal2-shown,
        html.swal2-height-auto,
        body.swal2-height-auto {
            height: 100% !important;
            overflow: hidden !important;
            padding-right: 0 !important;
        }

        /* Minimal Clean DataTables Controls Styling */
        .dataTables_wrapper {
            width: 100%;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            padding: 0.4rem 0.85rem;
            font-size: 0.875rem;
            background-color: #ffffff;
            outline: none;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            padding: 0.35rem 0.75rem;
            font-size: 0.875rem;
            background-color: #ffffff;
            outline: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            margin: 0 0.15rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #475569;
            background: #ffffff;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #0a2214 !important;
            color: #ffffff !important;
            border-color: #0a2214 !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 500;
        }
    </style>
    @stack('styles')
</head>

<body class="font-sans antialiased text-gray-900 bg-admin-bg flex h-screen overflow-hidden"
    style="font-family: 'Inter', sans-serif;">
    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-backdrop"
        class="fixed inset-0 bg-slate-900/50 z-20 lg:hidden hidden backdrop-blur-sm transition-all"
        onclick="toggleSidebar()"></div>

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
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'Aufilla Invitation') }} Admin Panel. All rights
                reserved.</span>
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
