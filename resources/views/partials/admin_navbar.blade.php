<!-- Admin Top Navbar -->
<header class="h-[70px] bg-white border-b border-slate-200/80 px-8 flex items-center justify-between shadow-sm z-20">
    <!-- Mobile Menu Toggle -->
    <button class="lg:hidden text-admin-dark hover:text-admin-accent transition-colors" onclick="$('#admin-sidebar').toggleClass('-translate-x-full');">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
    </button>

    <!-- Page Title -->
    <div class="hidden lg:flex items-center gap-3">
        <h1 class="text-admin-dark font-bold text-lg">@yield('page-title', 'Dashboard')</h1>
    </div>

    <!-- Right Side -->
    <div class="ml-auto flex items-center gap-4">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 text-slate-600 font-semibold hover:text-admin-dark transition-colors focus:outline-none">
                <div class="w-8 h-8 rounded-full bg-admin-accent/15 flex items-center justify-center text-admin-accent font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->username ?? 'A', 0, 2)) }}
                </div>
                <span class="hidden sm:inline">{{ Auth::user()->username ?? 'Admin' }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" style="display: none;"
                 class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-50">
                <div class="px-4 py-3 border-b border-slate-100">
                    <p class="text-xs text-slate-400 mb-1">Masuk sebagai:</p>
                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
