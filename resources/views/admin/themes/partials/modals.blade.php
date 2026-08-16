<!-- Create Theme Modal -->
<div id="create-theme-modal" class="fixed inset-0 z-[99999] hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
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
                <input type="text" name="name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none" placeholder="Aufilla Green">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kode Tema <span class="text-slate-400 font-normal lowercase">(slug/folder)</span></label>
                <input type="text" name="code" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm font-mono focus:ring-2 focus:ring-admin-accent focus:outline-none" placeholder="aufilla-green">
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
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
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
                <input type="text" name="name" id="edit-theme-name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Publikasi</label>
                <select name="is_active" id="edit-theme-status" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none bg-white">
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
