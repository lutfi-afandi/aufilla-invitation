<aside id="receptionist-sidebar" class="bg-recept-card w-64 lg:w-72 h-screen border-r border-recept-border flex flex-col fixed lg:static inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-30 shadow-2xl lg:shadow-none">
    <!-- Logo & Brand -->
    <div class="h-20 flex items-center px-6 border-b border-recept-border flex-shrink-0">
        <a href="{{ route('receptionist.dashboard') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-recept-primary rounded-lg flex items-center justify-center shadow-sm">
                <img src="{{ asset('assets/img/logo-icon.png') }}" alt="Aufilla Logo" class="w-5 h-5 object-contain invert brightness-0">
            </div>
            <div>
                <span class="text-lg font-bold text-recept-dark leading-tight block tracking-tight">Aufilla</span>
                <span class="text-[10px] text-slate-500 font-semibold tracking-wider uppercase">Receptionist</span>
            </div>
        </a>
        <button onclick="toggleSidebar()" class="lg:hidden ml-auto text-slate-400 hover:text-slate-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 custom-scrollbar">
        <!-- Dashboard Link -->
        <a href="{{ route('receptionist.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('receptionist.dashboard') ? 'bg-recept-primary text-white shadow-sm shadow-indigo-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-recept-primary' }}">
            <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            <span class="font-medium text-sm">Dashboard</span>
        </a>

        @if(request()->routeIs('receptionist.buku-tamu*'))
            <div class="pt-6 pb-2 px-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aktivitas</p>
            </div>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-indigo-50 text-recept-primary border border-indigo-100/50 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span class="font-medium text-sm">Buku Tamu</span>
            </a>
        @endif
    </nav>

    <!-- User Profile & Logout -->
    <div class="p-4 border-t border-recept-border flex-shrink-0">
        <div class="flex items-center gap-3 mb-4 px-2">
            <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold border border-slate-200">
                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-recept-dark truncate">{{ auth()->user()->username }}</p>
                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-red-600 transition-colors border border-slate-200 hover:border-red-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>
