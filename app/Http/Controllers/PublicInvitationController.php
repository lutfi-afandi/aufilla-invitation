<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;

class PublicInvitationController extends Controller
{
    public function show($slug)
    {
        $invitation = Invitation::with(['user', 'theme', 'acaras', 'galeris', 'ucapans'])->where('slug', $slug)->firstOrFail();

        // If theme is not set, fallback or 404
        if (!$invitation->theme) {
            abort(404, 'Tema belum dikonfigurasi.');
        }

        // If status is draft, only owner can see
        if ($invitation->status === 'draft') {
            if (!auth()->check() || auth()->id() !== $invitation->user_id) {
                abort(403, 'Undangan ini masih dalam status Draft.');
            }
        }

        // If nonaktif
        if ($invitation->status === 'nonaktif') {
            abort(404, 'Undangan ini sedang tidak aktif.');
        }

        $akad = $invitation->acaras->where('tipe_acara', 'akad')->first();
        $resepsi = $invitation->acaras->where('tipe_acara', 'resepsi')->first();
        $wishes = $invitation->ucapans()->orderBy('created_at', 'desc')->get(); // Fetch wishes
        $galeris = $invitation->galeris()->orderBy('created_at', 'desc')->get();
        $ceritas = $invitation->ceritas()->orderBy('tanggal', 'asc')->get();
        $kados = $invitation->kados()->orderBy('created_at', 'asc')->get();

        // Dynamically load the view based on the theme code
        $viewPath = 'themes.' . $invitation->theme->code . '.index';
        
        if (!view()->exists($viewPath)) {
            abort(500, 'File tema (' . $invitation->theme->code . ') tidak ditemukan di server.');
        }

        return view($viewPath, compact('invitation', 'akad', 'resepsi', 'wishes', 'galeris', 'ceritas', 'kados'));
    }

    public function storeUcapan(Request $request, $slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'is_attending' => 'required|boolean',
            'message' => 'required|string',
        ]);

        $wish = $invitation->ucapans()->create([
            'nama' => $request->name,
            'kehadiran' => $request->is_attending ? 'hadir' : 'tidak',
            'pesan' => $request->message,
        ]);

        return response()->json([
            'message' => 'Konfirmasi berhasil dikirim!',
            'wish' => [
                'nama' => $wish->nama,
                'created_at' => $wish->created_at->diffForHumans()
            ]
        ]);
    }
}
