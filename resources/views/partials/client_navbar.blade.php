<!-- Top Navbar -->
<header class="h-[70px] bg-white border-b border-brand-accent/10 px-8 flex items-center justify-between shadow-[0_4px_15px_rgba(10,34,20,0.02)] z-20">
    <!-- Mobile Menu Toggle -->
    <button class="lg:hidden text-brand-dark hover:text-brand-medium transition-colors" onclick="$('#client-sidebar').toggleClass('-translate-x-full'); $('#sidebar-backdrop').toggleClass('hidden');">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
    </button>

    <!-- Page Title / Breadcrumb (Optional space) -->
    <div class="hidden lg:block text-brand-dark font-medium" style="font-family: 'Playfair Display', serif;">
        Panel Klien
    </div>

    <!-- User Menu Dropdown (Alpine.js or basic HTML structure, we'll use a simple flex group for now) -->
    <div class="ml-auto flex items-center gap-4">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 text-brand-dark font-bold hover:text-brand-medium transition-colors focus:outline-none">
                <span>{{ Auth::user()->username ?? 'Client' }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" style="display: none;"
                 class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] border border-brand-accent/15 py-2 z-50">
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Masuk sebagai:</p>
                    <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->email }}</p>
                </div>
                <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-accent/5 hover:text-brand-dark transition-colors">
                    Profil Saya
                </a>
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
