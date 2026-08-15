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

        /* Custom Tailwind Styling for DataTables */
        .dataTables_wrapper {
            padding: 1.25rem;
            background: #ffffff;
            border-radius: 1.5rem;
            border: 1px solid #e2e8f0;
        }
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
        }
        .dataTables_wrapper .dataTables_filter input {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            font-size: 0.875rem;
            margin-left: 0.5rem;
            outline: none;
            transition: all 0.2s;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .dataTables_wrapper .dataTables_length select {
            padding: 0.4rem 2rem 0.4rem 0.8rem;
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            font-size: 0.875rem;
            margin: 0 0.5rem;
            outline: none;
        }
        .dataTables_wrapper table.dataTable {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
            border: none !important;
        }
        .dataTables_wrapper table.dataTable thead th {
            padding: 0.875rem 1rem !important;
            border-bottom: 2px solid #e2e8f0 !important;
            background-color: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .dataTables_wrapper table.dataTable tbody td {
            padding: 1rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 0.875rem;
            color: #334155;
            vertical-align: middle;
        }
        .dataTables_wrapper table.dataTable tbody tr:hover {
            background-color: #f8fafc !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.4rem 0.8rem !important;
            margin: 0 0.15rem !important;
            border-radius: 0.5rem !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            color: #475569 !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #6366f1 !important;
            color: #ffffff !important;
            border-color: #6366f1 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            color: #1e293b !important;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
            padding-top: 0.75rem;
        }
    </style>
    @stack('styles')
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
