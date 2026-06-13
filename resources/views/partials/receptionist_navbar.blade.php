<header class="h-20 bg-recept-base/80 backdrop-blur-xl border-b border-recept-border sticky top-0 z-10 px-6 lg:px-10 flex items-center justify-between">
    <!-- Left: Mobile Menu Toggle & Title -->
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-recept-primary bg-white p-2 rounded-lg shadow-sm border border-slate-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
            </svg>
        </button>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-recept-dark tracking-tight">
                @yield('header_title', 'Resepsionis')
            </h1>
        </div>
    </div>

    <!-- Right: Current Date/Time -->
    <div class="hidden md:flex items-center gap-2.5 px-4 py-2 bg-white rounded-lg shadow-sm border border-slate-200">
        <svg class="w-4 h-4 text-recept-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <span class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
    </div>
</header>
