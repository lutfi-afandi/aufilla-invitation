<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 xl:gap-8">
    @forelse($themes as $theme)
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden hover:-translate-y-1 hover:shadow-md transition-all duration-300 group" id="theme-card-{{ $theme->id }}">
        <!-- Thumbnail -->
        <div class="aspect-[3/4] bg-gradient-to-br from-slate-100 to-slate-50 relative overflow-hidden">
            @if($theme->thumbnail)
                <img src="{{ asset('storage/' . $theme->thumbnail) }}" alt="{{ $theme->name }}" class="w-full h-full object-cover">
            @else
                <div class="flex items-center justify-center h-full">
                    <svg class="w-16 h-16 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                </div>
            @endif
            <!-- Status Badge -->
            <div class="absolute top-3 right-3">
                <button onclick="toggleTheme({{ $theme->id }})" class="text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full transition-colors cursor-pointer {{ $theme->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-red-100 text-red-600 hover:bg-red-200' }}" id="theme-badge-{{ $theme->id }}">
                    {{ $theme->is_active ? 'Aktif' : 'Nonaktif' }}
                </button>
            </div>
        </div>
        <!-- Info -->
        <div class="p-5">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <h3 class="text-base font-bold text-slate-800">{{ $theme->name }}</h3>
                    <p class="text-xs font-mono text-slate-400 mt-0.5">{{ $theme->code }}</p>
                </div>
                <span class="text-xs font-semibold text-admin-accent bg-indigo-50 px-2 py-0.5 rounded-full">{{ $theme->invitations_count }} klien</span>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <button onclick="openEditTheme({{ json_encode($theme) }})" class="flex-1 text-center px-3 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Edit</button>
                <a href="{{ route('theme.preview', $theme->code) }}" target="_blank" class="flex-1 text-center px-3 py-2 text-sm font-semibold text-admin-accent-dark bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-colors">Preview</a>
                <button onclick="deleteTheme({{ $theme->id }})" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors" title="Hapus">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 text-slate-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
        <p class="text-sm">Belum ada tema terdaftar.</p>
    </div>
    @endforelse
</div>

@if($themes->hasPages())
<div class="mt-8 flex justify-center">
    {{ $themes->links('admin.themes.partials.pagination') }}
</div>
@endif
