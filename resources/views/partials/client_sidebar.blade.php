<!-- Sidebar -->
<aside class="w-64 bg-gradient-to-b from-brand-dark to-brand-medium text-white flex-shrink-0 flex flex-col h-full border-r border-brand-accent/20 shadow-[4px_0_25px_rgba(10,34,20,0.15)] transition-all duration-300 z-30 fixed lg:relative -translate-x-full lg:translate-x-0" id="client-sidebar">
    <!-- Brand -->
    <div class="p-6 border-b border-brand-accent/10">
        <a href="{{ route('client.dashboard') }}" class="flex items-center gap-3 decoration-transparent">
            <!-- Icon Logo -->
            <img src="{{ asset('assets/img/logo-icon.png') }}" alt="Aufilla Icon" class="w-8 h-8 object-contain">
            <!-- Text Logo -->
            <img src="{{ asset('assets/img/logo-text.png') }}" alt="Aufilla Text" class="h-6 object-contain">
        </a>
    </div>

    <!-- User Profile Area -->
    <div class="px-6 py-5 bg-white/5 border-b border-brand-accent/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-brand-accent-dark border-2 border-brand-accent flex items-center justify-center text-white font-bold text-sm">
                {{ strtoupper(substr(Auth::user()->username ?? 'C', 0, 2)) }}
            </div>
            <div class="leading-tight">
                <span class="block text-white font-bold text-sm">{{ Auth::user()->username ?? 'Client' }}</span>
                <span class="block text-brand-accent text-xs mt-0.5">{{ Auth::user()->email }}</span>
            </div>
        </div>
    </div>

    <!-- Menu Items -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-2 custom-scrollbar">
        <!-- Dashboard -->
        <a href="{{ route('client.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ Request::routeIs('client.dashboard') ? 'bg-brand-accent/10 border-l-4 border-brand-accent text-brand-accent font-semibold' : 'text-white/70 hover:bg-brand-accent/5 hover:text-brand-accent border-l-4 border-transparent font-medium' }}">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            Dashboard
        </a>
        
        <!-- Kelola Undangan -->
        <a href="{{ route('client.pengantin') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('client.pengantin', 'client.acara', 'client.galeri', 'client.cerita', 'client.kado') ? 'bg-brand-accent/10 border-l-4 border-brand-accent text-brand-accent font-semibold' : 'text-white/70 hover:bg-brand-accent/5 hover:text-brand-accent border-l-4 border-transparent font-medium' }}">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            Kelola Undangan
        </a>

        <!-- Manajemen Tamu -->
        <a href="{{ route('client.tamu') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ Request::routeIs('client.tamu') ? 'bg-brand-accent/10 border-l-4 border-brand-accent text-brand-accent font-semibold' : 'text-white/70 hover:bg-brand-accent/5 hover:text-brand-accent border-l-4 border-transparent font-medium' }}">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/></svg>
            Buku Tamu
        </a>



        <!-- Pengaturan -->
        <a href="{{ route('client.pengaturan') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ Request::routeIs('client.pengaturan') ? 'bg-brand-accent/10 border-l-4 border-brand-accent text-brand-accent font-semibold' : 'text-white/70 hover:bg-brand-accent/5 hover:text-brand-accent border-l-4 border-transparent font-medium' }}">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.06-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.73,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.06,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.43-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.49-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/></svg>
            Pengaturan Tema
        </a>
    </nav>
</aside>
