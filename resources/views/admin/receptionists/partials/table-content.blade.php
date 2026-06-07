<table class="w-full text-sm">
    <thead>
        <tr class="bg-slate-50 border-b border-slate-200">
            <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Username</th>
            <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Email</th>
            <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Terdaftar</th>
            <th class="text-center px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100">
        @forelse($receptionists as $r)
            @include('admin.receptionists.partials.row', ['r' => $r])
        @empty
        <tr>
            <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                Belum ada resepsionis terdaftar.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@if($receptionists->hasPages())
<div class="px-6 py-4 border-t border-slate-200 pagination-container">
    {{ $receptionists->links() }}
</div>
@endif
