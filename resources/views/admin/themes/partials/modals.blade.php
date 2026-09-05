<!-- Create Theme Modal -->
<div id="create-theme-modal" class="fixed inset-0 z-[99999] hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
            <h3 class="font-bold text-lg text-slate-800">Tambah Tema Baru</h3>
            <button type="button" onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Error Alert Container -->
        <div id="create-form-errors" class="hidden p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700">
            <ul class="list-disc list-inside space-y-1"></ul>
        </div>

        <form id="create-theme-form" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Tema</label>
                <input type="text" name="name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none" placeholder="Aufilla Maroon">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kode Tema <span class="text-slate-400 font-normal lowercase">(slug/folder)</span></label>
                <input type="text" name="code" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none" placeholder="aufilla-maroon">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                    <select name="category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none bg-white">
                        <option value="minimalis">Minimalis</option>
                        <option value="tradisional_jawa">Tradisional Jawa</option>
                        <option value="tradisional_minang">Tradisional Minang</option>
                        <option value="islami">Islami</option>
                        <option value="modern_floral">Modern / Floral</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tingkatan</label>
                    <select name="tingkatan" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none bg-white">
                        <option value="standar">Standar (Free)</option>
                        <option value="premium">Premium</option>
                        <option value="eksklusif">Eksklusif VIP</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Tambahan (Rp)</label>
                    <input type="number" name="harga_tambahan" min="0" step="5000" value="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none" placeholder="0">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Visibilitas</label>
                    <select name="is_privat" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none bg-white">
                        <option value="0">Publik (Katalog)</option>
                        <option value="1">Privat / VIP (Unlisted)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Thumbnail Gambar</label>
                <input type="file" name="thumbnail" id="create-thumbnail-input" accept="image/*" class="w-full border border-slate-200 rounded-xl px-3 py-1.5 text-xs text-slate-600 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-all">
                <div id="create-preview-container" class="mt-3 hidden rounded-xl overflow-hidden border border-slate-200 h-44 aspect-[3/4] mx-auto bg-slate-50 relative shadow-inner">
                    <img id="create-thumbnail-preview" src="" alt="Preview" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                <button type="submit" id="btnSubmitCreate" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition-colors flex items-center gap-2">
                    Tambah Tema
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Theme Modal -->
<div id="edit-theme-modal" class="fixed inset-0 z-[99999] hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
            <h3 class="font-bold text-lg text-slate-800" id="edit-modal-title">Edit Tema</h3>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Error Alert Container -->
        <div id="edit-form-errors" class="hidden p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700">
            <ul class="list-disc list-inside space-y-1"></ul>
        </div>

        <form id="edit-theme-form" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" id="edit-theme-id">

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Tema</label>
                <input type="text" name="name" id="edit-theme-name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                    <select name="category" id="edit-theme-category" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none bg-white">
                        <option value="minimalis">Minimalis</option>
                        <option value="tradisional_jawa">Tradisional Jawa</option>
                        <option value="tradisional_minang">Tradisional Minang</option>
                        <option value="islami">Islami</option>
                        <option value="modern_floral">Modern / Floral</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tingkatan</label>
                    <select name="tingkatan" id="edit-theme-tingkatan" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none bg-white">
                        <option value="standar">Standar (Free)</option>
                        <option value="premium">Premium</option>
                        <option value="eksklusif">Eksklusif VIP</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Tambahan (Rp)</label>
                    <input type="number" name="harga_tambahan" id="edit-theme-harga-tambahan" min="0" step="5000" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none" placeholder="0">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Visibilitas</label>
                    <select name="is_privat" id="edit-theme-is-privat" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none bg-white">
                        <option value="0">Publik (Katalog)</option>
                        <option value="1">Privat / VIP (Unlisted)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Publikasi</label>
                <select name="is_active" id="edit-theme-status" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 focus:outline-none bg-white">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Thumbnail <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                <input type="file" name="thumbnail" id="edit-thumbnail-input" accept="image/*" class="w-full border border-slate-200 rounded-xl px-3 py-1.5 text-xs text-slate-600 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-all">
                <div id="edit-preview-container" class="mt-3 rounded-xl overflow-hidden border border-slate-200 h-44 aspect-[3/4] mx-auto bg-slate-50 relative shadow-inner">
                    <img id="edit-thumbnail-preview" src="" alt="Preview" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                <button type="submit" id="btnSubmitEdit" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition-colors flex items-center gap-2">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
