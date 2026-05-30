<div class="bg-white border-b border-brand-accent/15 mb-6 rounded-[20px] shadow-[0_4px_20px_rgba(10,34,20,0.02)] overflow-hidden relative">
    <!-- Hint for Mobile -->
    <div class="md:hidden flex items-center justify-between px-4 py-1.5 bg-brand-light/10 text-[10px] text-brand-dark/60 font-medium border-b border-brand-accent/10">
        <span>Geser tab menu </span>
        <svg class="w-3 h-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
    </div>
    
    <div class="flex overflow-x-auto hide-scrollbar snap-x snap-mandatory">
        <a href="{{ route('client.pengantin') }}" 
           class="whitespace-nowrap px-6 py-4 text-sm font-medium transition-all border-b-2 {{ request()->routeIs('client.pengantin') ? 'border-brand-accent text-brand-accent bg-brand-light/10' : 'border-transparent text-gray-500 hover:text-brand-dark hover:bg-gray-50' }}">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Data Pengantin
            </div>
        </a>

        <a href="{{ route('client.acara') }}" 
           class="whitespace-nowrap px-6 py-4 text-sm font-medium transition-all border-b-2 {{ request()->routeIs('client.acara') ? 'border-brand-accent text-brand-accent bg-brand-light/10' : 'border-transparent text-gray-500 hover:text-brand-dark hover:bg-gray-50' }}">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Data Acara
            </div>
        </a>

        <a href="{{ route('client.galeri') }}" 
           class="whitespace-nowrap px-6 py-4 text-sm font-medium transition-all border-b-2 {{ request()->routeIs('client.galeri') ? 'border-brand-accent text-brand-accent bg-brand-light/10' : 'border-transparent text-gray-500 hover:text-brand-dark hover:bg-gray-50' }}">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Galeri Foto
            </div>
        </a>

        <a href="{{ route('client.cerita') }}" 
           class="whitespace-nowrap px-6 py-4 text-sm font-medium transition-all border-b-2 {{ request()->routeIs('client.cerita') ? 'border-brand-accent text-brand-accent bg-brand-light/10' : 'border-transparent text-gray-500 hover:text-brand-dark hover:bg-gray-50' }}">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Cerita Cinta
            </div>
        </a>

        <a href="{{ route('client.kado') }}" 
           class="whitespace-nowrap px-6 py-4 text-sm font-medium transition-all border-b-2 {{ request()->routeIs('client.kado') ? 'border-brand-accent text-brand-accent bg-brand-light/10' : 'border-transparent text-gray-500 hover:text-brand-dark hover:bg-gray-50' }}">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Kado Digital
            </div>
        </a>
    </div>
</div>

<style>
/* Utility to hide scrollbar but keep functionality */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
