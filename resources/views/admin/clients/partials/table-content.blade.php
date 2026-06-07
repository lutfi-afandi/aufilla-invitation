<table class="w-full text-sm">
    <thead>
        <tr class="bg-slate-50 border-b border-slate-200">
            <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Username</th>
            <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Paket</th>
            <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Tema</th>
            <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Status</th>
            <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Terdaftar</th>
            <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Expired</th>
            <th class="text-center px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100">
        @forelse($clients as $client)
            @include('admin.clients.partials.row', ['client' => $client])
        @empty
        <tr>
            <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Belum ada klien terdaftar.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
@if($clients->hasPages())
<div class="px-6 py-4 border-t border-slate-200 pagination-container">
    {{ $clients->links() }}
</div>
@endif
