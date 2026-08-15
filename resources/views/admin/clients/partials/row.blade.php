@php
    $undangan = $client->undangans->first();
@endphp
<tr class="hover:bg-slate-50/50 transition-colors group" id="client-row-{{ $client->id }}">
    <!-- Username & Email -->
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-admin-accent/20 flex items-center justify-center text-admin-accent-dark font-bold text-sm shadow-sm border border-admin-accent/10">
                {{ strtoupper(substr($client->username, 0, 2)) }}
            </div>
            <div class="flex flex-col">
                <span class="font-bold text-slate-800">{{ $client->username }}</span>
                <span class="text-[11px] text-slate-400 font-medium">{{ $client->email ?: 'Tanpa Email' }}</span>
            </div>
        </div>
    </td>

    <!-- Custom Slug Undangan -->
    <td class="px-6 py-4 whitespace-nowrap">
        @if ($undangan && $undangan->slug)
            <a href="/{{ $undangan->slug }}" target="_blank"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-admin-accent hover:text-admin-accent-dark hover:underline bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200"
                title="Buka Undangan">
                <svg class="w-3.5 h-3.5 text-admin-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
                /{{ $undangan->slug }}
            </a>
        @else
            <span class="text-xs text-slate-400">—</span>
        @endif
    </td>

    <!-- Paket -->
    <td class="px-6 py-4 whitespace-nowrap">
        @if ($undangan && $undangan->paket)
            <span class="text-xs font-bold text-slate-700 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                {{ $undangan->paket->name }}
            </span>
        @else
            <span class="text-xs text-slate-400">—</span>
        @endif
    </td>

    <!-- Tema -->
    <td class="px-6 py-4 whitespace-nowrap">
        @if ($undangan && $undangan->tema)
            <div
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50/80 border border-indigo-100">
                <div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div>
                <span class="text-xs font-bold text-indigo-700">{{ $undangan->tema->name }}</span>
            </div>
        @else
            <span class="text-xs text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">—</span>
        @endif
    </td>

    <!-- Status -->
    <td class="px-6 py-4 whitespace-nowrap">
        @if ($undangan)
            @php $s = $undangan->status; @endphp
            <span
                class="inline-flex w-fit items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-lg border {{ $s === 'aktif' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-red-50 border-red-200 text-red-600' }}">
                <span
                    class="shrink-0 w-1.5 h-1.5 rounded-full {{ $s === 'aktif' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                <span>{{ $s }}</span>
            </span>
        @else
            <span class="text-xs text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">Belum
                ada</span>
        @endif
    </td>

    <!-- Terdaftar -->
    <td class="px-6 py-4 whitespace-nowrap text-slate-500 text-xs font-medium">
        {{ $client->created_at ? $client->created_at->format('d M Y') : '-' }}</td>

    <!-- Expired -->
    <td class="px-6 py-4 whitespace-nowrap text-slate-500 text-xs font-medium">
        @if ($undangan && $undangan->expired_at)
            @if ($undangan->paket && $undangan->paket->active_days > 10000)
                <span class="text-emerald-600 font-semibold">Selamanya</span>
            @else
                {{ $undangan->expired_at->format('d M Y') }}
            @endif
        @else
            —
        @endif
    </td>

    <!-- Aksi -->
    <td class="px-6 py-4 whitespace-nowrap text-center">
        <div class="flex items-center justify-center gap-2">
            <button type="button" onclick="openDetailModal({{ $client->id }})"
                class="w-8 h-8 rounded-lg bg-white hover:bg-indigo-50 text-slate-400 hover:text-indigo-600 flex items-center justify-center transition-all shadow-sm border border-slate-200 hover:border-indigo-200"
                title="Detail Klien">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                    </path>
                </svg>
            </button>
            <button type="button" onclick="openEditModal({{ $client->id }})"
                class="w-8 h-8 rounded-lg bg-white hover:bg-amber-50 text-slate-400 hover:text-amber-600 flex items-center justify-center transition-all shadow-sm border border-slate-200 hover:border-amber-200"
                title="Edit Klien">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 01-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </button>
            <a href="{{ route('admin.clients.impersonate', $client->id) }}"
                class="w-8 h-8 rounded-lg bg-white hover:bg-emerald-50 text-slate-400 hover:text-emerald-600 flex items-center justify-center transition-all shadow-sm border border-slate-200 hover:border-emerald-200"
                title="Login sebagai klien">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                    </path>
                </svg>
            </a>
            <div class="w-px h-5 bg-slate-200 mx-1"></div>
            <button type="button" onclick="deleteClient({{ $client->id }}, '{{ addslashes($client->username) }}')"
                class="w-8 h-8 rounded-lg bg-white hover:bg-red-50 text-slate-400 hover:text-red-600 flex items-center justify-center transition-all shadow-sm border border-slate-200 hover:border-red-200"
                title="Hapus Klien">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </button>
        </div>
    </td>
</tr>
