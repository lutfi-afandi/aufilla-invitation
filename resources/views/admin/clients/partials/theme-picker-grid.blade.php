<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
    @forelse($themes as $theme)
        <div class="relative group cursor-pointer border-2 border-transparent rounded-xl overflow-hidden hover:border-admin-accent transition-all duration-300 theme-card" 
             data-id="{{ $theme->id }}" 
             data-name="{{ $theme->name }}" 
             onclick="selectTheme({{ $theme->id }}, '{{ addslashes($theme->name) }}', this)">
            
            <div class="h-32 bg-slate-100 relative overflow-hidden">
                @if($theme->thumbnail)
                    <img src="{{ asset('storage/' . $theme->thumbnail) }}" alt="{{ $theme->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="flex items-center justify-center h-full text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                
                <!-- Selected Overlay -->
                <div class="absolute inset-0 bg-admin-accent/20 flex items-center justify-center opacity-0 transition-opacity duration-300 selected-overlay">
                    <div class="bg-admin-accent text-white rounded-full p-1.5 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
            </div>
            
            <div class="p-3 bg-white border-t border-slate-100">
                <h4 class="font-bold text-sm text-slate-800 truncate">{{ $theme->name }}</h4>
                <p class="text-[10px] text-slate-400 font-mono mt-0.5 truncate">{{ $theme->code }}</p>
            </div>
        </div>
    @empty
        <div class="col-span-full py-8 text-center text-slate-400">
            <p class="text-sm">Tidak ada tema aktif yang ditemukan.</p>
        </div>
    @endforelse
</div>
