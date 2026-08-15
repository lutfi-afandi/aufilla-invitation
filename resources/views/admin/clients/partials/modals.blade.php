<!-- Create Client Modal -->
<div id="create-modal" class="fixed inset-0 z-[99999] bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="font-bold text-lg text-slate-800">Tambah Klien Baru</h3>
                <p class="text-xs text-slate-500 mt-0.5">Buat akun pengguna dan inisialisasi undangan.</p>
            </div>
            <button type="button" onclick="closeModal('create-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="create-form" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Tema Undangan <span class="text-red-500">*</span></label>
                <input type="hidden" name="theme_id" id="create-theme-id" required>
                <button type="button" onclick="openThemePicker('create')" class="w-full flex items-center justify-between p-3 bg-white border-2 border-slate-200 rounded-xl hover:border-admin-accent transition-all text-left group shadow-sm">
                    <div class="flex items-center gap-3">
                        <div id="create-theme-icon" class="w-12 h-16 bg-slate-50 rounded-lg border border-slate-100 flex items-center justify-center shrink-0 overflow-hidden">
                            <svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span id="create-theme-name" class="block font-bold text-slate-700 text-sm mb-0.5">Belum memilih tema</span>
                            <span class="block text-xs text-slate-500">Klik untuk memilih tema dari katalog</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 group-hover:bg-admin-accent group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </button>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Username Login <span class="text-red-500">*</span></label>
                    <input type="text" name="username" id="create-username" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Username login">
                </div>
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">URL Slug Undangan <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" id="create-slug" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Slug URL (misal: romeo-juliet)">
                </div>
            </div>
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Email <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                <input type="email" name="email" id="create-email" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="contoh@email.com">
            </div>

            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Paket Undangan <span class="text-red-500">*</span></label>
                <select name="package_id" id="create-package" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}">{{ $pkg->name }} (Aktif {{ $pkg->active_days }} hari)</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" id="create-password" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Minimal 6 karakter">
            </div>
            
            <div class="pt-2">
                <button type="submit" id="create-submit-btn" class="w-full inline-flex justify-center items-center px-4 py-3 bg-admin-accent-dark border border-transparent rounded-xl font-bold text-sm text-white tracking-wider uppercase hover:bg-admin-accent transition duration-150 shadow-sm">
                    Buat Akun Klien
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Client Modal -->
<div id="edit-modal" class="fixed inset-0 z-[99999] bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="font-bold text-lg text-slate-800">Edit Klien</h3>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi akun, paket, status, atau tema undangan.</p>
            </div>
            <button type="button" onclick="closeModal('edit-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="edit-form" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="edit-id">
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Tema Undangan <span class="text-red-500">*</span></label>
                <input type="hidden" name="theme_id" id="edit-theme-id" required>
                <button type="button" onclick="openThemePicker('edit')" class="w-full flex items-center justify-between p-3 bg-white border-2 border-slate-200 rounded-xl hover:border-admin-accent transition-all text-left group shadow-sm">
                    <div class="flex items-center gap-3">
                        <div id="edit-theme-icon" class="w-12 h-16 bg-slate-50 rounded-lg border border-slate-100 flex items-center justify-center shrink-0 overflow-hidden">
                            <svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span id="edit-theme-name" class="block font-bold text-slate-700 text-sm mb-0.5">Belum memilih tema</span>
                            <span class="block text-xs text-slate-500">Klik untuk mengubah tema undangan</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 group-hover:bg-admin-accent group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </button>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Username Login <span class="text-red-500">*</span></label>
                    <input type="text" name="username" id="edit-username" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                </div>
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">URL Slug Undangan <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" id="edit-slug" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                </div>
            </div>
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Email <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                <input type="email" name="email" id="edit-email" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700" placeholder="contoh@email.com">
            </div>

            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Paket Undangan <span class="text-red-500">*</span></label>
                <select name="package_id" id="edit-package" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}">{{ $pkg->name }} (Aktif {{ $pkg->active_days }} hari)</option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Status Undangan <span class="text-red-500">*</span></label>
                    <select name="status" id="edit-status" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                        <option value="aktif">Aktif</option>
                        <option value="kedaluwarsa">Kedaluwarsa</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Password Baru <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                    <input type="password" name="password" id="edit-password" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Kosongkan jika tak diubah">
                </div>
            </div>
            
            <div class="pt-2">
                <button type="submit" id="edit-submit-btn" class="w-full inline-flex justify-center items-center px-4 py-3 bg-admin-accent-dark border border-transparent rounded-xl font-bold text-sm text-white tracking-wider uppercase hover:bg-admin-accent transition duration-150 shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Detail Client Modal -->
<div id="detail-modal" class="fixed inset-0 z-[99999] bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
            <div>
                <h3 class="font-bold text-lg text-slate-800">Detail & Statistik Klien</h3>
                <p class="text-xs text-slate-500 mt-0.5">Informasi lengkap undangan, tema, dan data interaktif.</p>
            </div>
            <button type="button" onclick="closeModal('detail-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto">
            <div id="detail-loader" class="py-12 text-center flex flex-col items-center justify-center text-slate-400">
                <svg class="w-8 h-8 animate-spin mb-3 text-admin-accent" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <p class="text-sm font-medium">Memuat data klien...</p>
            </div>
            <div id="detail-content" style="display:none;">
                <!-- Server Rendered Partial view inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- Theme Picker Modal -->
<div id="theme-picker-modal" class="fixed inset-0 z-[100000] bg-black/50 backdrop-blur-sm items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[85vh]">
        <div class="bg-admin-dark p-5 text-white flex justify-between items-center shrink-0">
            <div>
                <h3 class="font-bold text-lg">Pilih Tema Undangan</h3>
                <p class="text-xs text-white/60 mt-0.5">Pilih tema visual yang akan digunakan oleh klien ini.</p>
            </div>
            <button type="button" onclick="closeThemePicker()" class="text-white/60 hover:text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <div class="p-4 border-b border-slate-100 bg-slate-50 shrink-0">
            <div class="relative max-w-md w-full mx-auto">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" id="search-theme-picker" placeholder="Cari nama tema..." onkeyup="filterThemes()" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all bg-white">
            </div>
        </div>
        <div class="p-6 overflow-y-auto">
            @include('admin.clients.partials.theme-picker-grid')
        </div>
    </div>
</div>
