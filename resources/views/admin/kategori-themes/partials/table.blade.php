<div id="category-table-wrapper" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="py-3.5 px-4 text-center w-12">Urutan</th>
                    <th class="py-3.5 px-4">Nama Kategori</th>
                    <th class="py-3.5 px-4">Slug Key</th>
                    <th class="py-3.5 px-4 text-center">Jumlah Tema</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($categories as $category)
                <tr class="hover:bg-slate-50/80 transition-colors group" id="category-row-{{ $category->id }}">
                    <!-- Urutan -->
                    <td class="py-3 px-4 text-center">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 font-bold text-xs text-slate-700 border border-slate-200/60">
                            {{ $category->urutan }}
                        </span>
                    </td>

                    <!-- Nama Kategori -->
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-800 text-sm">{{ $category->nama }}</span>
                        </div>
                    </td>

                    <!-- Slug Key -->
                    <td class="py-3 px-4">
                        <span class="font-mono text-xs text-indigo-700 bg-indigo-50/80 px-2 py-0.5 rounded border border-indigo-100">
                            {{ $category->slug }}
                        </span>
                    </td>

                    <!-- Jumlah Tema -->
                    <td class="py-3 px-4 text-center">
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-full">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $category->temas_count }} tema
                        </span>
                    </td>

                    <!-- Status Toggle Badge -->
                    <td class="py-3 px-4 text-center">
                        <button type="button" onclick="toggleCategory({{ $category->id }})" 
                                id="category-badge-{{ $category->id }}"
                                class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold tracking-wider uppercase transition-all cursor-pointer {{ $category->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200 border border-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 border border-slate-200' }}">
                            {{ $category->is_active ? 'AKTIF' : 'NONAKTIF' }}
                        </button>
                    </td>

                    <!-- Action Buttons -->
                    <td class="py-3 px-4 text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <button type="button" onclick="openEditCategory({{ json_encode($category) }})" 
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg shadow-2xs transition-colors" title="Edit Kategori">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>

                            <button type="button" onclick="deleteCategory({{ $category->id }}, {{ $category->temas_count }})" 
                                    class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors border border-transparent hover:border-rose-100" title="Hapus Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <p class="text-sm font-medium">Belum ada kategori tema.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
    <div class="p-4 border-t border-slate-100 flex items-center justify-between">
        {{ $categories->links() }}
    </div>
    @endif
</div>
