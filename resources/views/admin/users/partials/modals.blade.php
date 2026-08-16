<!-- Create User Modal -->
<div id="create-modal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
            <h3 class="font-bold text-lg text-slate-800">Tambah Admin Baru</h3>
            <button type="button" onclick="closeModal('create-modal')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Error Alert Container -->
        <div id="create-form-errors" class="hidden p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700">
            <ul class="list-disc list-inside space-y-1"></ul>
        </div>

        <form id="create-form" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Username <span class="text-rose-500">*</span></label>
                <input type="text" name="username" id="create-username" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none" placeholder="Masukkan username admin">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                <input type="email" name="email" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none" placeholder="admin@example.com">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input type="password" name="password" required class="w-full px-3.5 py-2 pr-10 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none" placeholder="Minimal 6 karakter">
                    <button type="button" onclick="const input = this.previousElementSibling; const isPass = input.type === 'password'; input.type = isPass ? 'text' : 'password';" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
            </div>
            
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('create-modal')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                <button type="submit" id="btnSubmitCreateUser" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition-colors flex items-center gap-2">
                    Simpan Admin
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="edit-modal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
            <h3 class="font-bold text-lg text-slate-800">Edit Admin</h3>
            <button type="button" onclick="closeModal('edit-modal')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Error Alert Container -->
        <div id="edit-form-errors" class="hidden p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700">
            <ul class="list-disc list-inside space-y-1"></ul>
        </div>

        <form id="edit-form" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id">

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Username <span class="text-rose-500">*</span></label>
                <input type="text" name="username" id="edit-username" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                <input type="email" name="email" id="edit-email" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password Baru <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                <div class="relative">
                    <input type="password" name="password" class="w-full px-3.5 py-2 pr-10 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none" placeholder="Kosongkan jika tidak diubah">
                    <button type="button" onclick="const input = this.previousElementSibling; const isPass = input.type === 'password'; input.type = isPass ? 'text' : 'password';" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
            </div>
            
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal('edit-modal')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                <button type="submit" id="btnSubmitEditUser" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition-colors flex items-center gap-2">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
