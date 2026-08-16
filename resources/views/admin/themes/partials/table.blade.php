<div id="themes-table-wrapper" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="py-3.5 px-4 text-center w-12">No</th>
                    <th class="py-3.5 px-4 w-36">Thumbnail</th>
                    <th class="py-3.5 px-4">Nama Tema</th>
                    <th class="py-3.5 px-4">Kode Tema</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center">Preview</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($themes as $index => $theme)
                <tr class="hover:bg-slate-50/80 transition-colors group" id="theme-row-{{ $theme->id }}">
                    <!-- No -->
                    <td class="py-3 px-4 text-center text-xs font-medium text-slate-400">
                        {{ $themes->firstItem() + $index }}
                    </td>

                    <!-- Thumbnail -->
                    <td class="py-3 px-4">
                        <div class="w-14 aspect-[3/4] rounded-lg overflow-hidden border border-slate-200 bg-slate-100 shadow-2xs relative group-hover:shadow-xs transition-shadow">
                            @if($theme->thumbnail)
                                <img src="{{ asset('storage/' . $theme->thumbnail) }}" alt="{{ $theme->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('assets/img/thumbnail-tema/demo1.png') }}" alt="{{ $theme->name }}" class="w-full h-full object-cover opacity-80 mix-blend-multiply">
                            @endif
                        </div>
                    </td>

                    <!-- Nama Tema & Badge -->
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-800">{{ $theme->name }}</span>
                            <span class="text-[10px] font-semibold text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-full">
                                {{ $theme->undangans_count }} klien
                            </span>
                        </div>
                    </td>

                    <!-- Kode Tema -->
                    <td class="py-3 px-4">
                        <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-md border border-slate-200/60">
                            {{ $theme->code }}
                        </span>
                    </td>

                    <!-- Status Toggle Badge -->
                    <td class="py-3 px-4 text-center">
                        <button type="button" onclick="toggleTheme({{ $theme->id }})" 
                                id="theme-badge-{{ $theme->id }}"
                                class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold tracking-wider uppercase transition-all cursor-pointer {{ $theme->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200 border border-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 border border-slate-200' }}">
                            {{ $theme->is_active ? 'AKTIF' : 'NONAKTIF' }}
                        </button>
                    </td>

                    <!-- Preview Link -->
                    <td class="py-3 px-4 text-center">
                        <a href="{{ route('theme.preview', $theme->code) }}" target="_blank" 
                           class="inline-flex items-center gap-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50/80 hover:bg-indigo-100 px-3 py-1.5 rounded-lg border border-indigo-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview
                        </a>
                    </td>

                    <!-- Action Buttons -->
                    <td class="py-3 px-4 text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <button type="button" onclick="openEditTheme({{ json_encode($theme) }})" 
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg shadow-2xs transition-colors" title="Edit Tema">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>

                            <button type="button" onclick="deleteTheme({{ $theme->id }})" 
                                    class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors border border-transparent hover:border-rose-100" title="Hapus Tema">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm font-medium">Tidak ada data tema yang ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-xs text-slate-500">
            Menampilkan <span class="font-semibold text-slate-700">{{ $themes->firstItem() ?? 0 }}</span> sampai <span class="font-semibold text-slate-700">{{ $themes->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-slate-700">{{ $themes->total() }}</span> tema
        </p>

        @if($themes->hasPages())
        <div class="ajax-pagination">
            {{ $themes->links('admin.themes.partials.pagination') }}
        </div>
        @endif
    </div>
</div>
