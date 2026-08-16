<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="paket-list-grid">
    @foreach($pakets as $paket)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between relative overflow-hidden">
        @if($paket->name === 'Trial')
        <span class="absolute top-3 right-3 px-2.5 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full uppercase tracking-wider">Default Trial</span>
        @endif

        <div>
            <h3 class="text-lg font-bold text-slate-800">{{ $paket->name }}</h3>
            <div class="mt-3 flex items-baseline gap-1">
                <span class="text-3xl font-black text-slate-900">Rp {{ number_format($paket->price, 0, ',', '.') }}</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Durasi: <span class="font-bold text-slate-700">{{ $paket->active_days }} Hari</span></p>

            <div class="my-4 border-t border-slate-100"></div>

            <ul class="space-y-2.5 text-xs text-slate-600">
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Limit Kirim WA: <span class="font-bold text-slate-800">{{ $paket->max_wa_send > 10000 ? 'Unlimited' : $paket->max_wa_send . ' Kirim' }}</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Maksimal {{ $paket->max_gallery_photos }} Foto Galeri
                </li>
                <li class="flex items-center gap-2">
                    @if($paket->has_love_story)
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-medium text-slate-700">Fitur Cerita Cinta</span>
                    @else
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span class="text-slate-400">Tanpa Cerita Cinta</span>
                    @endif
                </li>
                <li class="flex items-center gap-2">
                    @if($paket->can_custom_music)
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-medium text-slate-700">Kustom Musik Latar</span>
                    @else
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span class="text-slate-400">Musik Default</span>
                    @endif
                </li>
            </ul>

            @if($paket->description)
            <p class="text-xs text-slate-400 mt-4 italic bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $paket->description }}</p>
            @endif
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
            <span class="text-xs text-slate-400 font-medium">{{ $paket->undangans_count }} Pengguna</span>
            <div class="flex items-center gap-2">
                <button onclick="openModalEdit({{ json_encode($paket) }})" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Paket">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>

                @if($paket->name !== 'Trial')
                <button type="button" onclick="deletePaket({{ $paket->id }})" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Paket">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
