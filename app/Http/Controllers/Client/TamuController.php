<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TamuController extends Controller
{
    public function index()
    {
        $invitation = Auth::user()->invitation;
        if (!$invitation) {
            return response()->json([]);
        }
        $tamus = $invitation->tamus()->orderBy('created_at', 'desc')->get();
        return response()->json($tamus);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'no_wa' => 'nullable|string|max:20',
        ]);

        $invitation = Auth::user()->invitation;
        
        $tamu = $invitation->tamus()->create([
            'nama_tamu' => $request->nama_tamu,
            'no_wa' => $request->no_wa,
        ]);

        return response()->json([
            'success' => true,
            'tamu' => $tamu,
            'wa_link' => $this->generateWaLink($invitation->slug, $tamu->nama_tamu)
        ]);
    }

    public function destroy($id)
    {
        $invitation = Auth::user()->invitation;
        $tamu = $invitation->tamus()->findOrFail($id);
        $tamu->delete();

        return response()->json(['success' => true]);
    }

    private function generateWaLink($slug, $namaTamu)
    {
        // Construct the invitation link
        $link = url('/' . $slug . '?to=' . urlencode($namaTamu));
        
        // Default text for sending via WhatsApp
        $text = "Halo, kami mengundang Anda ke pernikahan kami! Silakan lihat detailnya di: " . $link;
        return "https://wa.me/?text=" . urlencode($text);
    }
}
