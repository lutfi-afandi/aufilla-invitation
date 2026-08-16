<div class="space-y-6">
    <!-- Header Profile -->
    <div class="flex items-center justify-between pb-5 border-b border-slate-100">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-50 to-admin-accent/20 flex items-center justify-center text-admin-accent-dark font-bold text-xl shadow-sm border border-admin-accent/10">
                {{ strtoupper(substr($client->username, 0, 2)) }}
            </div>
            <div>
                <h4 class="text-lg font-bold text-slate-800">{{ $client->username }}</h4>
                <p class="text-slate-500 text-xs flex items-center gap-1.5 mt-0.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ $client->email ?: 'Tanpa Email' }}
                </p>
            </div>
        </div>
        <div>
            @if($undangan)
                <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border {{ $undangan->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-600 border-red-200' }}">
                    {{ $undangan->status }}
                </span>
            @else
                <span class="text-xs bg-slate-100 text-slate-500 px-2 py-1 rounded">Belum ada</span>
            @endif
        </div>
    </div>

    <!-- Info Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
        <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100">
            <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Mempelai</span>
            <p class="font-bold text-slate-700 text-xs truncate">
                {{ $undangan ? (($undangan->wanita_nama ?: 'Wanita') . ' & ' . ($undangan->pria_nama ?: 'Pria')) : 'Belum diisi' }}
            </p>
        </div>
        <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100">
            <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Paket Undangan</span>
            <p class="font-bold text-slate-700 text-xs">{{ $undangan?->paket?->name ?? '—' }}</p>
        </div>
        <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100">
            <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Tema Visual</span>
            <p class="font-bold text-slate-700 text-xs">{{ $undangan?->tema?->name ?? '—' }}</p>
        </div>
        <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100">
            <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">URL Slug</span>
            <p class="font-bold text-admin-accent text-xs truncate">{{ $undangan ? ('/' . $undangan->slug) : '—' }}</p>
        </div>
        <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100">
            <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Terdaftar Sejak</span>
            <p class="font-bold text-slate-700 text-xs">{{ $client->created_at->format('d M Y') }}</p>
        </div>
        <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100">
            <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Masa Aktif</span>
            <p class="font-bold text-slate-700 text-xs">
                @if($undangan && $undangan->expired_at)
                    {{ $undangan->expired_at->format('d M Y') }}
                @else
                    —
                @endif
            </p>
        </div>
    </div>

    <!-- Statistik Undangan -->
    <div>
        <h5 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Statistik Data Undangan</h5>
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 text-center">
            <div class="p-3 bg-indigo-50/60 rounded-xl border border-indigo-100">
                <span class="block text-lg font-black text-indigo-700">{{ $stats['total_tamu'] ?? 0 }}</span>
                <span class="text-[11px] font-medium text-slate-600">Tamu</span>
            </div>
            <div class="p-3 bg-purple-50/60 rounded-xl border border-purple-100">
                <span class="block text-lg font-black text-purple-700">{{ $stats['total_ucapan'] ?? 0 }}</span>
                <span class="text-[11px] font-medium text-slate-600">Ucapan</span>
            </div>
            <div class="p-3 bg-pink-50/60 rounded-xl border border-pink-100">
                <span class="block text-lg font-black text-pink-700">{{ $stats['total_galeri'] ?? 0 }}</span>
                <span class="text-[11px] font-medium text-slate-600">Galeri</span>
            </div>
            <div class="p-3 bg-amber-50/60 rounded-xl border border-amber-100">
                <span class="block text-lg font-black text-amber-700">{{ $stats['total_cerita'] ?? 0 }}</span>
                <span class="text-[11px] font-medium text-slate-600">Cerita</span>
            </div>
            <div class="p-3 bg-emerald-50/60 rounded-xl border border-emerald-100">
                <span class="block text-lg font-black text-emerald-700">{{ $stats['total_kado'] ?? 0 }}</span>
                <span class="text-[11px] font-medium text-slate-600">Kado</span>
            </div>
            <div class="p-3 bg-sky-50/60 rounded-xl border border-sky-100">
                <span class="block text-lg font-black text-sky-700">{{ $stats['total_acara'] ?? 0 }}</span>
                <span class="text-[11px] font-medium text-slate-600">Acara</span>
            </div>
        </div>
    </div>

    <!-- Action Buttons Footer -->
    <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <button type="button" onclick="closeModal('detail-modal'); openEditModal({{ $client->id }});" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-amber-50 text-slate-700 hover:text-amber-700 text-xs font-semibold rounded-xl border border-slate-200 hover:border-amber-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 01-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Klien
            </button>
            <a href="{{ route('admin.clients.impersonate', $client->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 text-xs font-semibold rounded-xl border border-slate-200 hover:border-emerald-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Login Klien
            </a>
        </div>
        @if($undangan && $undangan->slug)
        <a href="{{ url('/' . $undangan->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-admin-accent-dark hover:bg-admin-accent rounded-xl shadow-sm transition-all">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Buka Undangan
        </a>
        @endif
    </div>
</div>
