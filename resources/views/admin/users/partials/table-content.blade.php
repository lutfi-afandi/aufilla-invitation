<table class="w-full text-left border-collapse whitespace-nowrap">
    <thead>
        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[10px] uppercase tracking-wider font-bold">
            <th class="px-6 py-4 w-12 text-center">No</th>
            <th class="px-6 py-4">Username & Email</th>
            <th class="px-6 py-4">Terdaftar Pada</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100 text-sm">
        @forelse($users as $user)
        <tr class="hover:bg-slate-50/50 transition-colors group">
            <td class="px-6 py-4 text-center text-slate-400 font-medium">
                {{ $users->firstItem() + $loop->index }}
            </td>
            <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 font-bold shrink-0">
                        {{ strtoupper(substr($user->username, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-slate-800">{{ $user->username }}</div>
                        <div class="text-xs text-slate-500 mt-0.5">{{ $user->email ?? '-' }}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 text-slate-500 font-medium text-xs">
                {{ $user->created_at->format('d M Y') }}
                <div class="text-[10px] text-slate-400 mt-0.5">{{ $user->created_at->format('H:i') }} WIB</div>
            </td>
            <td class="px-6 py-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <button onclick="openEditModal({{ $user->id }})" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Pengguna">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    @if($user->id !== auth()->id())
                    <button onclick="deleteUser({{ $user->id }})" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Pengguna">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <p class="font-medium text-slate-600">Tidak ada pengguna ditemukan</p>
                <p class="text-sm mt-1">Coba gunakan kata kunci pencarian atau filter lain.</p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@if($users->hasPages())
<div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
    {{ $users->links() }}
</div>
@endif
