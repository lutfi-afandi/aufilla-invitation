<div id="tab-contact-content" class="setting-tab-content space-y-6 hidden">
    <form id="form-setting-contact" class="space-y-6">
        @csrf
        <input type="hidden" name="group" value="contact">

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 space-y-6">
            <div>
                <h4 class="font-bold text-base text-slate-800">Kontak & Media Sosial</h4>
                <p class="text-xs text-slate-500">Nomor WhatsApp layanan pelanggan, email support, akun media sosial, dan alamat operasional.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- WhatsApp CTA -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp Konsultasi / CS</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">+</span>
                        <input type="text" name="contact_whatsapp" value="{{ $settings['contact_whatsapp'] ?? '6281234567890' }}" required
                               class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                               placeholder="6281234567890">
                    </div>
                    <p class="mt-1 text-[11px] text-slate-400">Gunakan format internasional tanpa spasi (misal: 6281234567890).</p>
                </div>

                <!-- Email Support -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Layanan Pelanggan</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'support@aufilla.com' }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                           placeholder="support@aufilla.com">
                    <p class="mt-1 text-[11px] text-slate-400">Email yang ditampilkan pada footer landing page.</p>
                </div>

                <!-- Instagram Handle -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Akun Instagram</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">@</span>
                        <input type="text" name="contact_instagram" value="{{ $settings['contact_instagram'] ?? 'aufilla.invitation' }}"
                               class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                               placeholder="aufilla.invitation">
                    </div>
                    <p class="mt-1 text-[11px] text-slate-400">Username akun Instagram resmi.</p>
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat / Kota Domisili</label>
                    <input type="text" name="contact_address" value="{{ $settings['contact_address'] ?? 'Jakarta, Indonesia' }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                           placeholder="Jakarta, Indonesia">
                    <p class="mt-1 text-[11px] text-slate-400">Lokasi / kota kantor penyedia layanan.</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="btn-save-setting inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-xs hover:shadow-md transition-all">
                    Simpan Kontak & Sosmed
                </button>
            </div>
        </div>
    </form>
</div>
