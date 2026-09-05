<div id="tab-seo-content" class="setting-tab-content space-y-6 hidden">
    <form id="form-setting-seo" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="group" value="seo">

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 space-y-6">
            <div>
                <h4 class="font-bold text-base text-slate-800">Optimasi Mesin Pencari (SEO) & Social Share</h4>
                <p class="text-xs text-slate-500">Pengaturan meta tags untuk Google Search serta pratinjau kartu share saat link dibagikan ke WhatsApp & Facebook.</p>
            </div>

            <div class="space-y-5">
                <!-- Meta Title -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Meta Title (SEO Title)</label>
                    <input type="text" name="meta_title" value="{{ $settings['meta_title'] ?? '' }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                           placeholder="Contoh: Platform Undangan Pernikahan Digital Elegan & Modern">
                    <p class="mt-1 text-[11px] text-slate-400">Judul utama halaman untuk SEO. Jika kosong, akan menggunakan format Nama Brand — Tagline.</p>
                </div>

                <!-- Meta Description -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Meta Description</label>
                    <textarea name="meta_description" rows="3"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                              placeholder="Deskripsi singkat website untuk hasil pencarian Google...">{{ $settings['meta_description'] ?? '' }}</textarea>
                    <p class="mt-1 text-[11px] text-slate-400">Direkomendasikan antara 140 - 160 karakter.</p>
                </div>

                <!-- Meta Keywords -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? '' }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                           placeholder="undangan online, undangan pernikahan digital, buat undangan website">
                    <p class="mt-1 text-[11px] text-slate-400">Pisahkan kata kunci dengan tanda koma (,).</p>
                </div>

                <!-- Meta Author -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Meta Author</label>
                    <input type="text" name="meta_author" value="{{ $settings['meta_author'] ?? 'Aufilla Invitation' }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                </div>

                <!-- Open Graph Share Banner -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Gambar Pratinjau Sosial (Open Graph Banner / 1200x630)</label>
                    <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 flex flex-col sm:flex-row items-center gap-4">
                        <div id="preview-container-og" class="w-full sm:w-48 h-28 rounded-lg overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center shrink-0 relative">
                            @php
                                $ogSrc = !empty($settings['app_og_image']) ? asset('storage/' . $settings['app_og_image']) : asset('assets/img/brand-white-og.png');
                            @endphp
                            <img src="{{ $ogSrc }}" data-initial-src="{{ $ogSrc }}" id="preview-og" class="w-full h-full object-cover {{ empty($settings['app_og_image']) ? 'opacity-80' : '' }}" alt="OG Preview">
                        </div>
                        <div class="space-y-2 text-center sm:text-left">
                            <div id="status-og" class="hidden"></div>
                            <input type="file" name="app_og_image" id="input-og" accept="image/*" class="hidden">
                            <div class="flex items-center gap-2 justify-center sm:justify-start">
                                <button type="button" onclick="$('#input-og').click()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Upload Banner OG
                                </button>
                                <button type="button" id="btn-cancel-og" onclick="cancelImagePreview('input-og', 'preview-og', 'btn-cancel-og', 'status-og')" class="hidden text-xs font-semibold text-rose-500 hover:text-rose-700">
                                    (Batal)
                                </button>
                            </div>
                            <p class="text-[11px] text-slate-400">Format gambar JPG, PNG, atau WebP (Rasio 1.91:1, disarankan 1200 x 630 px).</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="btn-save-setting inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-xs hover:shadow-md transition-all">
                    Simpan Pengaturan SEO
                </button>
            </div>
        </div>
    </form>
</div>
