@extends('layouts.client')

@section('title', 'Manajemen Tamu - Aufilla Invitation')

@section('content')
<style>
    .swal-z-index {
        z-index: 99999 !important;
    }
</style>
<div class="max-w-7xl mx-auto w-full">
    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-4 md:px-7 py-4 md:py-5 flex flex-col md:flex-row md:justify-between items-start md:items-center gap-4 md:gap-0">
            <div class="flex items-center gap-3">
                <h3 class="text-[1.15rem] font-semibold text-brand-dark" style="font-family: 'Playfair Display', serif;">Buku Tamu</h3>
                @php
                    $undanganUser = Auth::user()->undangans()->first();
                    $maxWa = $undanganUser && $undanganUser->paket ? $undanganUser->paket->max_wa_send : 99999;
                    $sendCount = $undanganUser ? $undanganUser->wa_send_count : 0;
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $sendCount >= $maxWa ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Kirim WA: <strong id="badge-wa-count">{{ $sendCount }}</strong> / {{ $maxWa > 10000 ? '∞' : $maxWa }}
                </span>
            </div>
            <div class="flex flex-wrap items-center gap-2 md:gap-3 w-full md:w-auto">
                <a href="{{ route('client.tamu.export') }}" class="flex-1 md:flex-none justify-center bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-3 md:px-4 py-2 rounded-xl text-xs md:text-sm font-medium transition-colors shadow-sm flex items-center gap-1.5 md:gap-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export
                </a>
                
                @if(!Auth::user()->invitation || !Auth::user()->invitation?->isExpired())
                    @if(\App\Helpers\PackageHelper::canAddGuest(Auth::user()->invitation))
                    <button onclick="$('#modal-import').removeClass('hidden').addClass('flex');" class="flex-1 md:flex-none justify-center bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-3 md:px-4 py-2 rounded-xl text-xs md:text-sm font-medium transition-colors shadow-sm flex items-center gap-1.5 md:gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Import
                    </button>
                    @endif
                    
                    <button onclick="$('#modal-wa').removeClass('hidden').addClass('flex');" class="flex-1 md:flex-none justify-center bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-3 md:px-4 py-2 rounded-xl text-xs md:text-sm font-medium transition-colors shadow-sm flex items-center gap-1.5 md:gap-2">
                        <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Pesan WA
                    </button>
                    
                    @if(\App\Helpers\PackageHelper::canAddGuest(Auth::user()->invitation))
                    <button onclick="$('#modal-tamu').removeClass('hidden').addClass('flex');" class="w-full md:w-auto mt-2 md:mt-0 justify-center bg-brand-dark hover:bg-brand-medium text-white px-4 md:px-5 py-2 rounded-xl text-xs md:text-sm font-medium transition-colors shadow-sm flex items-center gap-1.5 md:gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah
                    </button>
                    @else
                    <div class="w-full md:w-auto mt-2 md:mt-0 px-4 py-2 bg-red-100 text-red-700 rounded-xl text-xs md:text-sm font-semibold border border-red-200">
                        Kuota Tamu Penuh
                    </div>
                    @endif
                @endif
            </div>
            </div>
        </div>
        
        <!-- Card Body -->
        <div class="px-7 py-4 border-b border-brand-accent/15 flex justify-between items-center bg-gray-50/50">
            <div class="relative w-full max-w-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="search-tamu" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-brand-accent focus:border-brand-accent sm:text-sm transition-colors" placeholder="Cari nama tamu atau no WA...">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-brand-dark/5 text-brand-dark uppercase text-xs font-semibold tracking-wide border-b border-brand-accent/15">
                        <th class="px-7 py-4">Nama Tamu</th>
                        <th class="px-7 py-4">No. WhatsApp</th>
                        <th class="px-7 py-4">Status WA</th>
                        <th class="px-7 py-4 text-center">Kode QR</th>
                        @if(!Auth::user()->invitation || !Auth::user()->invitation->isExpired())
                        <th class="px-7 py-4 text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-accent/10 text-sm text-gray-700" id="tamu-list">
                    <!-- Data AJAX will be populated here -->
                    <tr class="hover:bg-brand-accent/5 transition-colors">
                        <td colspan="5" class="px-7 py-8 text-center text-gray-500 italic">Memuat data tamu...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div id="pagination-container" class="px-7 py-4 border-t border-brand-accent/15 bg-gray-50/50 flex justify-between items-center">
            <!-- Rendered via JS -->
        </div>
    </div>
</div>

<!-- Modal Tambah Tamu -->
<div id="modal-tamu" class="fixed inset-0 z-50 hidden bg-brand-dark/40 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-brand-accent/15 bg-brand-bg flex justify-between items-center">
            <h3 class="text-lg font-bold text-brand-dark" style="font-family: 'Playfair Display', serif;">Tambah Tamu Baru</h3>
            <button onclick="$('#modal-tamu').removeClass('flex').addClass('hidden');" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="form-tambah-tamu" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-brand-dark mb-1">Nama Tamu</label>
                    <input type="text" name="nama_tamu" id="tamu_nama" required class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Masukkan nama tamu">
                </div>
                <div>
                    <label class="block text-sm font-medium text-brand-dark mb-1">No. WhatsApp <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="no_wa" id="tamu_wa" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: 08123456789">
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="$('#modal-tamu').removeClass('flex').addClass('hidden');" class="px-5 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-xl font-medium transition-colors text-sm">Batal</button>
                <button type="submit" id="btn-save-tamu" class="px-5 py-2.5 bg-brand-dark hover:bg-brand-medium text-white rounded-xl font-medium transition-colors text-sm shadow-sm flex items-center">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Import CSV -->
<div id="modal-import" class="fixed inset-0 z-50 hidden bg-brand-dark/40 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-brand-accent/15 bg-brand-bg flex justify-between items-center">
            <h3 class="text-lg font-bold text-brand-dark" style="font-family: 'Playfair Display', serif;">Import Data Tamu</h3>
            <button onclick="$('#modal-import').removeClass('flex').addClass('hidden');" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="form-import-csv" class="p-6" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div class="bg-blue-50 text-blue-700 p-4 rounded-xl text-sm border border-blue-100 flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-semibold mb-1">Panduan Import Data</p>
                        <p class="mb-2">Gunakan format file Excel (.xlsx / .xls) atau CSV dengan kolom <b>Nama Tamu</b> dan <b>No WhatsApp</b>. Anda dapat mengunduh *template* Excel di bawah ini.</p>
                        <a href="{{ route('client.tamu.template') }}" class="inline-block bg-white border border-blue-200 text-blue-600 px-3 py-1.5 rounded-lg font-medium hover:bg-blue-100 transition-colors">Unduh Template Excel</a>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-brand-dark mb-1">File Excel / CSV</label>
                    <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls,.csv" required class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none">
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="$('#modal-import').removeClass('flex').addClass('hidden');" class="px-5 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-xl font-medium transition-colors text-sm">Batal</button>
                <button type="submit" id="btn-import-tamu" class="px-5 py-2.5 bg-brand-dark hover:bg-brand-medium text-white rounded-xl font-medium transition-colors text-sm shadow-sm flex items-center">Import Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Pengaturan Pesan WA -->
<div id="modal-wa" class="fixed inset-0 z-50 hidden bg-brand-dark/40 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-brand-accent/15 bg-brand-bg flex justify-between items-center">
            <h3 class="text-lg font-bold text-brand-dark" style="font-family: 'Playfair Display', serif;">Pengaturan Pesan WA</h3>
            <button onclick="$('#modal-wa').removeClass('flex').addClass('hidden');" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6">
            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl text-sm border border-blue-100 mb-4">
                <p class="font-semibold mb-2">Panduan Format Pesan:</p>
                <ul class="list-disc pl-4 space-y-1">
                    <li>Gunakan <code>[nama_tamu]</code> untuk menyisipkan nama tamu otomatis.</li>
                    <li>Gunakan <code>[link_undangan]</code> untuk menyisipkan URL undangan otomatis.</li>
                    <li>Tebal (Bold): <code>*teks*</code></li>
                    <li>Miring (Italic): <code>_teks_</code></li>
                    <li>Coret (Strikethrough): <code>~teks~</code></li>
                </ul>
            </div>
            <textarea id="wa_template_input" rows="8" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-3 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none resize-none" placeholder="Masukkan template pesan WhatsApp di sini..."></textarea>
        </div>
        <div class="px-6 py-4 border-t border-brand-accent/15 flex justify-end gap-3 bg-gray-50/50">
            <button type="button" onclick="$('#modal-wa').removeClass('flex').addClass('hidden');" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl font-medium transition-colors text-sm shadow-sm">Batal</button>
            <button type="button" id="btn-save-wa" class="px-5 py-2.5 bg-brand-dark hover:bg-brand-medium text-white rounded-xl font-medium transition-colors text-sm shadow-sm flex items-center">Simpan Pesan</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Load Data Tamu
        let currentPage = 1;
        let currentSearch = '';

        window.loadTamu = function(page = 1, search = '') {
            currentPage = page;
            currentSearch = search;
            $('#tamu-list').html('<tr><td colspan="4" class="px-7 py-8 text-center text-gray-500 italic">Memuat data...</td></tr>');
            
            $.get("{{ route('client.tamu.data') }}", { page: page, search: search }, function(response) {
                let html = '';
                let data = response.data; // Because of paginate()
                
                let isExpired = {{ (!Auth::user()->invitation || Auth::user()->invitation?->isExpired()) ? 'true' : 'false' }};
                
                if(data.length === 0) {
                    html = `<tr><td colspan="${isExpired ? '4' : '5'}" class="px-7 py-8 text-center text-gray-500 italic border-b border-brand-accent/10">Belum ada data tamu.</td></tr>`;
                } else {
                    data.forEach(function(item) {
                        let isWaSent = item.is_wa_sent ? 'checked' : '';
                        let slug = "{{ Auth::user()->invitation?->slug ?? '' }}";
                        let link = window.location.origin + "/" + slug + "?to=" + encodeURIComponent(item.nama_tamu);
                        html += `
                        <tr class="hover:bg-brand-accent/5 transition-colors border-b border-brand-accent/10 last:border-0" id="tamu-${item.id}">
                            <td class="px-7 py-4 text-sm font-medium text-gray-800">${item.nama_tamu}</td>
                            <td class="px-7 py-4 text-sm text-gray-500">${item.no_wa || '-'}</td>
                            <td class="px-7 py-4">
                                ${isExpired ? 
                                    `<span class="px-3 py-1 text-xs rounded border ${item.is_wa_sent ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-600 border-gray-200'}">${item.is_wa_sent ? 'Terkirim' : 'Belum'}</span>`
                                :
                                    `<label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer toggle-wa" data-id="${item.id}" ${isWaSent}>
                                        <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500"></div>
                                    </label>`
                                }
                            </td>
                            <td class="px-7 py-4 text-center">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 font-mono text-xs rounded border border-gray-200 tracking-widest">
                                    ${item.kode_qr}
                                </span>
                            </td>
                            ${!isExpired ? `
                            <td class="px-7 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=${item.kode_qr}" download="QR_${item.nama_tamu}.png" target="_blank" class="text-brand-accent hover:text-brand-dark transition-colors btn-download-qr" title="Download QR (PNG)">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                    <button class="text-gray-400 hover:text-brand-dark transition-colors btn-copy" data-link="${link}" title="Salin Link Undangan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>
                                    <button class="text-[#25D366] hover:text-[#1EBE5D] transition-colors btn-wa" data-slug="${slug}" data-nama="${item.nama_tamu}" data-wa="${item.no_wa || ''}" title="Kirim WA Manual">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </button>
                                    <button class="text-red-400 hover:text-red-600 transition-colors btn-delete-tamu" data-id="${item.id}" title="Hapus Tamu">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>` : ''}
                        </tr>
                        `;
                    });
                }
                $('#tamu-list').html(html);
                renderPagination(response);
            });
        }

        function renderPagination(response) {
            let html = '';
            if (response.last_page > 1) {
                html += '<div class="text-sm font-medium text-gray-500">Menampilkan <span class="text-brand-dark">' + response.from + '</span> - <span class="text-brand-dark">' + response.to + '</span> dari <span class="text-brand-dark">' + response.total + '</span></div>';
                html += '<div class="flex gap-2">';
                
                // Prev button
                let prevDisabled = response.current_page <= 1 
                    ? 'disabled class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-gray-400 text-sm cursor-not-allowed flex items-center gap-1"' 
                    : `onclick="loadTamu(${response.current_page - 1}, '${currentSearch}')" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-brand-dark hover:bg-gray-50 hover:border-gray-300 transition-all text-sm font-medium shadow-sm flex items-center gap-1"`;
                
                html += `<button ${prevDisabled}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Sebelumnya
                        </button>`;
                
                // Next button
                let nextDisabled = response.current_page >= response.last_page 
                    ? 'disabled class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-gray-400 text-sm cursor-not-allowed flex items-center gap-1"' 
                    : `onclick="loadTamu(${response.current_page + 1}, '${currentSearch}')" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-brand-dark hover:bg-gray-50 hover:border-gray-300 transition-all text-sm font-medium shadow-sm flex items-center gap-1"`;
                
                html += `<button ${nextDisabled}>
                            Selanjutnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>`;
                
                html += '</div>';
            } else if (response.total > 0) {
                html = `<div class="text-sm font-medium text-gray-500">Total <span class="text-brand-dark">${response.total}</span> tamu</div>`;
            }
            $('#pagination-container').html(html);
        }

        loadTamu();

        // Live Search Debounce
        let searchTimeout;
        $('#search-tamu').on('keyup', function() {
            clearTimeout(searchTimeout);
            let val = $(this).val();
            searchTimeout = setTimeout(function() {
                loadTamu(1, val);
            }, 500); // 500ms delay
        });

        // Template Pesan WA (Disimpan sementara di LocalStorage untuk preview)
        let defaultWaTemplate = "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i *[nama_tamu]* untuk menghadiri acara pernikahan kami.\n\nBerikut link undangan kami, untuk info lengkap dari acara bisa kunjungi :\n\n[link_undangan]\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\nMohon maaf perihal undangan hanya dibagikan melalui pesan ini.\n\nTerima kasih banyak atas perhatian dan doanya.";
        let savedTemplate = localStorage.getItem('wa_template');
        let currentWaTemplate = savedTemplate ? savedTemplate : defaultWaTemplate;

        // Custom WA Template button logic
        $('#wa_template_input').val(currentWaTemplate);
        
        $('#btn-save-wa').on('click', function() {
            let newVal = $('#wa_template_input').val();
            localStorage.setItem('wa_template', newVal);
            currentWaTemplate = newVal;
            $('#modal-wa').removeClass('flex').addClass('hidden');
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Pesan WA tersimpan!', showConfirmButton: false, timer: 2000 });
        });

        // Sanitize WA number on input
        $('#tamu_wa').on('input', function() {
            let val = $(this).val();
            // Remove everything except numbers and plus sign (if they start with +62)
            val = val.replace(/[^0-9+]/g, '');
            // Convert +62 or 62 at the beginning to 0
            if (val.startsWith('+62')) {
                val = '0' + val.substring(3);
            } else if (val.startsWith('62')) {
                val = '0' + val.substring(2);
            }
            $(this).val(val);
        });

        // Submit Form Tamu
        $('#form-tambah-tamu').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#btn-save-tamu');
            var originalText = btn.html();
            btn.html('<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...').prop('disabled', true);

            $.ajax({
                url: "{{ route('client.tamu.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    btn.html(originalText).prop('disabled', false);
                    $('#form-tambah-tamu')[0].reset();
                    $('#modal-tamu').removeClass('flex').addClass('hidden');
                    loadTamu();
                    
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tamu berhasil ditambahkan!',
                        showConfirmButton: false,
                        timer: 2500,
                        customClass: { popup: 'border-l-4 border-green-500 rounded-lg shadow-lg' }
                    });
                },
                error: function(xhr) {
                    btn.html(originalText).prop('disabled', false);
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menambah tamu.' });
                }
            });
        });

        // Delete Tamu (Event Delegation karena elemen dibuat via AJAX)
        $(document).on('click', '.btn-delete-tamu', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data ini akan hilang selamanya.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1d3226',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                width: '300px', // Minimalist width
                customClass: {
                    container: 'swal-z-index',
                    title: 'text-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/client/tamu/" + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Tamu dihapus!',
                                showConfirmButton: false,
                                timer: 2000,
                                customClass: { container: 'swal-z-index' }
                            });
                            // Hilangkan baris secara visual tanpa reload penuh
                            $('#tamu-' + id).fadeOut(300, function() { 
                                $(this).remove(); 
                            });
                        }
                    });
                }
            })
        });

        // Toggle WA Status
        $(document).on('change', '.toggle-wa', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "/client/tamu/" + id + "/toggle-wa",
                method: "POST",
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    // Berhasil mengubah status
                },
                error: function(xhr) {
                    Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Gagal update status', showConfirmButton: false, timer: 2000 });
                }
            });
        });

        // Submit Import Excel
        $('#form-import-csv').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#btn-import-tamu');
            var originalText = btn.html();
            btn.html('<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...').prop('disabled', true);

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('client.tamu.import') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    btn.html(originalText).prop('disabled', false);
                    $('#form-import-csv')[0].reset();
                    $('#modal-import').removeClass('flex').addClass('hidden');
                    loadTamu();
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data tamu berhasil diimpor.',
                    });
                },
                error: function(xhr) {
                    btn.html(originalText).prop('disabled', false);
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Format file tidak didukung atau terjadi kesalahan.' });
                }
            });
        });

        // Open WA Link
        $(document).on('click', '.btn-wa', function() {
            var btn = $(this);
            var slug = btn.data('slug');
            var nama = btn.data('nama');
            var noWa = btn.data('wa');
            var link = window.location.origin + "/" + slug + "?to=" + encodeURIComponent(nama);
            
            var text = currentWaTemplate.replace('[nama_tamu]', nama).replace('[link_undangan]', link);
            
            var waUrl;
            if (noWa) {
                var normalized = String(noWa).replace(/\D/g, '');
                if (normalized.startsWith('0')) normalized = '62' + normalized.slice(1);
                if (!normalized.startsWith('62')) normalized = '62' + normalized;
                waUrl = "https://wa.me/" + normalized + "?text=" + encodeURIComponent(text);
            } else {
                waUrl = "https://wa.me/?text=" + encodeURIComponent(text);
            }

            // Track WA Send via Backend
            $.ajax({
                url: "{{ route('client.tamu.trackWaSend') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.wa_send_count !== undefined) {
                        $('#badge-wa-count').text(response.wa_send_count);
                    }
                    window.open(waUrl, "_blank");
                },
                error: function(xhr) {
                    let errorMsg = 'Kuota kirim undangan Paket Trial Anda sudah habis.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'warning',
                        title: 'Kuota Kirim Habis!',
                        text: errorMsg,
                        confirmButtonText: 'Upgrade Paket',
                        confirmButtonColor: '#0a2214',
                        showCancelButton: true,
                        cancelButtonText: 'Tutup'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "https://wa.me/{{ config('app.activation_wa') }}?text=" + encodeURIComponent("Halo Admin Aufilla, saya ingin upgrade paket undangan.");
                        }
                    });
                }
            });
        });

        // Copy Link
        $(document).on('click', '.btn-copy', function() {
            var link = $(this).data('link');
            navigator.clipboard.writeText(link).then(function() {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Link disalin!', showConfirmButton: false, timer: 1500 });
            }, function() {
                Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Gagal menyalin', showConfirmButton: false, timer: 1500 });
            });
        });
    });
</script>
@endpush
