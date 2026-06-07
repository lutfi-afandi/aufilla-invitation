<tr class="hover:bg-slate-50/50 transition-colors" id="receptionist-row-{{ $r->id }}">
    <td class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-xs">
                {{ strtoupper(substr($r->username, 0, 2)) }}
            </div>
            <span class="font-semibold text-slate-700">{{ $r->username }}</span>
        </div>
    </td>
    <td class="px-6 py-4 text-slate-500">{{ $r->email }}</td>
    <td class="px-6 py-4 text-slate-400 text-xs">{{ $r->created_at->format('d M Y') }}</td>
    <td class="px-6 py-4">
        <div class="flex items-center justify-center gap-1">
            <button onclick="openEditReceptionist({{ json_encode($r) }})" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </button>
            <button onclick="deleteReceptionist({{ $r->id }})" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </div>
    </td>
</tr>
