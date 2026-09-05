<div id="tab-faq-content" class="setting-tab-content space-y-6 hidden">
    <form id="form-setting-faq" class="space-y-6">
        @csrf
        <input type="hidden" name="group" value="faq">

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h4 class="font-bold text-base text-slate-800">Daftar Tanya Jawab (FAQ)</h4>
                    <p class="text-xs text-slate-500">Kelola daftar pertanyaan umum yang ditampilkan pada accordion landing page. Geser item untuk mengubah urutan.</p>
                </div>
                <button type="button" onclick="addFaqItem()" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold text-xs rounded-xl border border-indigo-200 transition-all self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah FAQ Baru
                </button>
            </div>

            <!-- FAQ Repeater Container with SortableJS -->
            <div id="faq-repeater-container" class="space-y-4">
                @forelse($faqs as $index => $faq)
                <div class="faq-item bg-slate-50/70 border border-slate-200 rounded-2xl p-4 sm:p-5 transition-all relative group hover:border-slate-300">
                    <div class="flex items-start gap-3">
                        <!-- Drag Handle & Index Badge -->
                        <div class="flex flex-col items-center gap-1.5 shrink-0 pt-1">
                            <div class="faq-drag-handle p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-slate-200/60 rounded-lg cursor-grab active:cursor-grabbing transition-colors" title="Geser untuk mengubah urutan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="9" cy="6" r="1.5" fill="currentColor"></circle>
                                    <circle cx="15" cy="6" r="1.5" fill="currentColor"></circle>
                                    <circle cx="9" cy="12" r="1.5" fill="currentColor"></circle>
                                    <circle cx="15" cy="12" r="1.5" fill="currentColor"></circle>
                                    <circle cx="9" cy="18" r="1.5" fill="currentColor"></circle>
                                    <circle cx="15" cy="18" r="1.5" fill="currentColor"></circle>
                                </svg>
                            </div>
                            <span class="faq-index-badge inline-flex items-center justify-center w-6 h-6 rounded-md bg-white font-bold text-[11px] text-slate-600 border border-slate-200">
                                {{ $index + 1 }}
                            </span>
                        </div>

                        <!-- FAQ Inputs -->
                        <div class="flex-1 space-y-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Pertanyaan</label>
                                <input type="text" name="faqs[{{ $index }}][pertanyaan]" value="{{ $faq['pertanyaan'] ?? '' }}" required
                                       class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-semibold text-slate-800 bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                                       placeholder="Contoh: Berapa lama proses pembuatan undangan?">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Jawaban</label>
                                <textarea name="faqs[{{ $index }}][jawaban]" rows="2" required
                                          class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs sm:text-sm text-slate-700 bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                                          placeholder="Tuliskan jawaban yang jelas dan informatif...">{{ $faq['jawaban'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Delete Button -->
                        <button type="button" onclick="removeFaqItem(this)" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors border border-transparent hover:border-rose-100 shrink-0" title="Hapus FAQ">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @empty
                <div id="faq-empty-state" class="py-10 text-center text-slate-400 border-2 border-dashed border-slate-200 rounded-2xl">
                    <p class="text-sm font-medium">Belum ada daftar FAQ. Klik tombol "Tambah FAQ Baru" untuk mulai menambahkan.</p>
                </div>
                @endforelse
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="btn-save-setting inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-xs hover:shadow-md transition-all">
                    Simpan Daftar FAQ
                </button>
            </div>
        </div>
    </form>
</div>
