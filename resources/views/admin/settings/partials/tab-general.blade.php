<div id="tab-general-content" class="setting-tab-content space-y-6">
    <form id="form-setting-general" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="group" value="general">

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-6 space-y-6">
            <div>
                <h4 class="font-bold text-base text-slate-800">Identitas & Brand Aplikasi</h4>
                <p class="text-xs text-slate-500">Sesuaikan nama brand, tagline, dan aset visual aplikasi tanpa mengubah source code.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- App Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Aplikasi / Brand</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'Aufilla Invitation' }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                    <p class="mt-1 text-[11px] text-slate-400">Tampil di judul tab browser, navbar, dan hak cipta footer.</p>
                </div>

                <!-- App Tagline -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Slogan / Tagline</label>
                    <input type="text" name="app_tagline" value="{{ $settings['app_tagline'] ?? '' }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all"
                           placeholder="Undangan Pernikahan Digital Elegan & Modern">
                    <p class="mt-1 text-[11px] text-slate-400">Tagline pendukung nama brand di landing page.</p>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Visual Assets Upload -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- App Logo (Light Mode / Default) -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Logo Utama <span class="text-slate-400 font-normal lowercase">(Light)</span></label>
                    <div class="border border-slate-200 rounded-xl p-3 text-center bg-slate-50/50 hover:bg-slate-50 transition-colors flex flex-col items-center justify-center min-h-[140px] relative">
                        <div id="preview-container-logo" class="h-16 flex items-center justify-center mb-2">
                            @if(!empty($settings['app_logo']))
                                <img src="{{ asset('storage/' . $settings['app_logo']) }}" id="preview-logo" class="max-h-16 object-contain" alt="Logo">
                            @else
                                <img src="{{ asset('assets/img/brand-logo.png') }}" id="preview-logo" class="max-h-16 object-contain opacity-60" alt="Default Logo">
                            @endif
                        </div>
                        <input type="file" name="app_logo" id="input-logo" accept="image/*" class="hidden">
                        <button type="button" onclick="$('#input-logo').click()" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                            Ganti Logo
                        </button>
                    </div>
                </div>

                <!-- App Logo Dark (For Dark Headers / Cover) -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Logo Putih <span class="text-slate-400 font-normal lowercase">(Dark Mode)</span></label>
                    <div class="border border-slate-200 rounded-xl p-3 text-center bg-slate-900 transition-colors flex flex-col items-center justify-center min-h-[140px] relative">
                        <div id="preview-container-logo-dark" class="h-16 flex items-center justify-center mb-2">
                            @if(!empty($settings['app_logo_dark']))
                                <img src="{{ asset('storage/' . $settings['app_logo_dark']) }}" id="preview-logo-dark" class="max-h-16 object-contain" alt="Logo Dark">
                            @else
                                <img src="{{ asset('assets/img/brand-white.png') }}" id="preview-logo-dark" class="max-h-16 object-contain" alt="Default Logo Dark">
                            @endif
                        </div>
                        <input type="file" name="app_logo_dark" id="input-logo-dark" accept="image/*" class="hidden">
                        <button type="button" onclick="$('#input-logo-dark').click()" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300">
                            Ganti Logo Putih
                        </button>
                    </div>
                </div>

                <!-- App Favicon -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Favicon <span class="text-slate-400 font-normal lowercase">(Tab Icon)</span></label>
                    <div class="border border-slate-200 rounded-xl p-3 text-center bg-slate-50/50 hover:bg-slate-50 transition-colors flex flex-col items-center justify-center min-h-[140px] relative">
                        <div id="preview-container-favicon" class="h-16 flex items-center justify-center mb-2">
                            @if(!empty($settings['app_favicon']))
                                <img src="{{ asset('storage/' . $settings['app_favicon']) }}" id="preview-favicon" class="w-10 h-10 object-contain rounded-lg shadow-xs" alt="Favicon">
                            @else
                                <img src="{{ asset('assets/img/logo-icon.png') }}" id="preview-favicon" class="w-10 h-10 object-contain rounded-lg shadow-xs" alt="Default Favicon">
                            @endif
                        </div>
                        <input type="file" name="app_favicon" id="input-favicon" accept="image/*,.ico" class="hidden">
                        <button type="button" onclick="$('#input-favicon').click()" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                            Ganti Favicon
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="btn-save-setting inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-xs hover:shadow-md transition-all">
                    Simpan Identitas Brand
                </button>
            </div>
        </div>
    </form>
</div>
