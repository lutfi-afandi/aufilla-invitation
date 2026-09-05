<!-- Admin Sidebar -->
<aside class="w-64 bg-gradient-to-b from-admin-dark to-admin-medium text-white flex-shrink-0 flex flex-col h-full border-r border-white/5 shadow-[4px_0_25px_rgba(15,23,42,0.25)] transition-all duration-300 z-30 fixed lg:relative -translate-x-full lg:translate-x-0" id="admin-sidebar">
    <!-- Brand -->
    <div class="p-6 border-b border-white/10 bg-admin-dark/50">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 decoration-transparent hover:-translate-y-0.5 transition-transform duration-300">
            <!-- Icon Logo -->
            <img src="{{ asset('assets/img/logo-icon.png') }}" alt="Aufilla Logo" class="h-10 w-auto object-contain drop-shadow-md">
            <div class="flex flex-col justify-center">
                <span class="text-[20px] font-serif text-white tracking-tight leading-none drop-shadow-sm">
                    Aufilla<span class="italic text-admin-accent">Invitation</span>
                </span>
                <span class="text-[8px] font-sans font-bold tracking-[0.3em] uppercase text-white/60 mt-1 pl-0.5">
                    Admin Panel
                </span>
            </div>
        </a>
    </div>

    <!-- Admin Profile -->
    <div class="px-6 py-5 bg-white/5 border-b border-white/5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-admin-accent/20 border-2 border-admin-accent/50 flex items-center justify-center text-admin-accent font-bold text-sm">
                {{ strtoupper(substr(Auth::user()->username ?? 'A', 0, 2)) }}
            </div>
            <div class="leading-tight">
                <span class="block text-white font-bold text-sm">{{ Auth::user()->username ?? 'Admin' }}</span>
                <span class="block text-admin-muted text-xs mt-0.5">Administrator</span>
            </div>
        </div>
    </div>

    <!-- Menu Items -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1.5 custom-scrollbar">
        <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-admin-muted/60 mb-3">Menu Utama</p>

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.dashboard') ? 'bg-admin-accent/15 text-admin-accent font-semibold shadow-sm' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-admin-muted/60 mt-6 mb-3">Manajemen</p>

        <!-- Klien -->
        <a href="{{ route('admin.clients.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.clients.*') ? 'bg-admin-accent/15 text-admin-accent font-semibold shadow-sm' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Klien
        </a>

        <!-- Paket -->
        <a href="{{ route('admin.pakets.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.pakets.*') ? 'bg-admin-accent/15 text-admin-accent font-semibold shadow-sm' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Paket
        </a>

        <!-- Tema -->
        <a href="{{ route('admin.themes.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.themes.*') ? 'bg-admin-accent/15 text-admin-accent font-semibold shadow-sm' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
            Katalog Tema
        </a>

        <!-- Kategori Tema -->
        <a href="{{ route('admin.theme-categories.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.theme-categories.*') ? 'bg-admin-accent/15 text-admin-accent font-semibold shadow-sm' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Kategori Tema
        </a>

        <!-- Resepsionis -->
        <a href="{{ route('admin.receptionists.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ Request::routeIs('admin.receptionists.*') ? 'bg-admin-accent/15 text-admin-accent font-semibold shadow-sm' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            Resepsionis
        </a>
    </nav>

    <!-- Bottom -->
    <div class="p-4 border-t border-white/5 space-y-1">
        <a href="{{ route('admin.users.index') }}" 
           class="w-full flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl transition-all duration-200 {{ Request::routeIs('admin.users.*') ? 'bg-admin-accent/15 text-admin-accent font-semibold shadow-sm' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Kelola Admin
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-xl transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </div>
</aside>
