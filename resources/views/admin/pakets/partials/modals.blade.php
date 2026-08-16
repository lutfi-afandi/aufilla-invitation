<!-- Modal Form -->
<div id="paketModal" class="fixed inset-0 z-[99999] hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4">
        <h3 id="modalTitle" class="text-lg font-bold text-slate-800">Tambah Paket Baru</h3>

        <form id="paketForm" method="POST" action="" class="space-y-4">
            @csrf
            <div id="methodField"></div>

            <!-- Error Messages -->
            <div id="formErrors" class="hidden p-4 bg-rose-50 border border-rose-200 rounded-xl text-sm text-rose-700">
                <ul class="list-disc list-inside space-y-1"></ul>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Paket</label>
                <input type="text" name="name" id="paket_name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga (Rp)</label>
                    <input type="number" name="price" id="paket_price" required min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Masa Aktif (Hari)</label>
                    <input type="number" name="active_days" id="paket_active_days" required min="1" max="3650" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
                    <p class="text-[10px] text-slate-400 mt-0.5">*Maksimal 3650 hari (10 tahun)</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Maks Kirim WA</label>
                    <input type="number" name="max_wa_send" id="paket_max_wa_send" required min="1" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Maks Foto Galeri</label>
                    <input type="number" name="max_gallery_photos" id="paket_max_gallery_photos" required min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
                </div>
            </div>

            <div class="space-y-2 pt-2 border-t border-slate-100">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="has_love_story" id="paket_has_love_story" value="1" class="rounded border-slate-300 text-admin-accent focus:ring-admin-accent">
                    <span class="text-xs font-semibold text-slate-700">Dukungan Fitur Cerita Cinta</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="can_custom_music" id="paket_can_custom_music" value="1" class="rounded border-slate-300 text-admin-accent focus:ring-admin-accent">
                    <span class="text-xs font-semibold text-slate-700">Dukungan Kustom Musik Latar</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_priority_support" id="paket_is_priority_support" value="1" class="rounded border-slate-300 text-admin-accent focus:ring-admin-accent">
                    <span class="text-xs font-semibold text-slate-700">Priority Support</span>
                </label>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                <textarea name="description" id="paket_description" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                <button type="submit" id="btnSubmitPaket" class="px-4 py-2 text-sm font-semibold text-white bg-admin-accent hover:bg-admin-accent/90 rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
