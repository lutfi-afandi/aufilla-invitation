<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Klien') — {{ setting('app_name', 'Aufilla') }}</title>
    <!-- Favicon -->
    @if(setting('app_favicon'))
        <link rel="icon" href="{{ asset('storage/' . setting('app_favicon')) }}">
    @else
        <link rel="icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/png">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="{{ asset('assets/css/bunny-figtree.css') }}" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <style>
        .swal2-container {
            z-index: 99999 !important;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-brand-bg flex h-screen overflow-hidden">
    
    @if(session('admin_impersonate_id'))
    <div class="fixed top-0 left-0 right-0 z-[100] bg-admin-accent-dark text-white text-center py-2 text-sm font-semibold shadow-md">
        Anda sedang login sebagai <strong>{{ Auth::user()->username }}</strong>.
        <a href="{{ route('admin.impersonate.stop') }}" class="underline ml-2 hover:text-indigo-200">← Kembali ke Admin</a>
    </div>
    @endif

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-brand-dark/50 z-20 lg:hidden hidden backdrop-blur-sm transition-all" onclick="$('#client-sidebar').addClass('-translate-x-full'); $('#sidebar-backdrop').addClass('hidden');"></div>

    @include('partials.client_sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 bg-brand-bg relative">
        @include('partials.client_navbar')

        <!-- PJAX Container for SPA -->
        <div id="pjax-container" class="flex-1 flex flex-col overflow-y-auto custom-scrollbar relative">
            <!-- Page Content -->
            <main class="flex-1 p-6 md:p-8 lg:p-10">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-brand-accent/10 py-4 text-center text-sm text-gray-500 mt-auto flex-shrink-0">
                <span>&copy; {{ date('Y') }} {{ config('app.name', 'Aufilla Invitation') }} Klien. All rights reserved.</span>
            </footer>

            @stack('scripts')
        </div>
    
    <!-- Pjax-like SPA Script for Client Panel -->
    <script>
    $(document).ready(function() {
        // Intercept clicks on links that go to /client/...
        $(document).on('click', 'a', function(e) {
            let url = $(this).attr('href');
            let target = $(this).attr('target');
            
            // Ignore if no URL, external URL, hash, or target="_blank"
            if (!url || url.startsWith('#') || url.startsWith('javascript:') || target === '_blank') return;
            
            // Only intercept client routes
            let clientPath = '{{ url("/client") }}';
            let isTamuRoute = url.includes('/client/tamu');
            let currentIsTamu = window.location.pathname.includes('/client/tamu');
            
            if (url.startsWith(clientPath) && !url.includes('logout') && !url.includes('impersonate') && !isTamuRoute && !currentIsTamu) {
                e.preventDefault();
                
                // Show loading state in the container
                $('#pjax-container').html('<div class="flex items-center justify-center h-full min-h-[300px]"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand-accent"></div></div>');
                
                // Fetch new page via Ajax
                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(response) {
                        try {
                            let parser = new DOMParser();
                            let doc = parser.parseFromString(response, 'text/html');
                            
                            // Extract new pjax-container and sidebar active states
                            let newContainer = $(doc).find('#pjax-container').html();
                            let newSidebar = $(doc).find('nav').html(); // sidebar nav
                            let newTitle = doc.title;
                            
                            // Replace DOM
                            $('#pjax-container').html(newContainer);
                            document.title = newTitle;
                            
                            // Update Sidebar active state without reloading it
                            if (newSidebar) {
                                $('nav').html(newSidebar);
                            }
                            
                            // Update History
                            history.pushState(null, newTitle, url);
                            
                            // Re-trigger any document ready functions if necessary
                            // Usually form events are delegated, but if there's direct binding, trigger an event
                            $(document).trigger('pjax:success');
                            
                            // Close mobile sidebar if open
                            $('#client-sidebar').addClass('-translate-x-full');
                            $('#sidebar-backdrop').addClass('hidden');
                            
                            // Reset SweetAlert instances if any overlay is stuck
                            if(typeof Swal !== 'undefined') Swal.close();
                        } catch (err) {
                            console.error('SPA Parse Error:', err);
                            window.location.href = url; // fallback
                        }
                    },
                    error: function() {
                        window.location.href = url; // fallback
                    }
                });
            }
        });
        
        // Handle Back/Forward browser buttons
        window.addEventListener('popstate', function() {
            window.location.reload();
        });
    });
    </script>
</body>
</html>
