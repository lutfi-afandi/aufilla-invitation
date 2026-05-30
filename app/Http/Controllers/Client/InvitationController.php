<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function updateMempelai(Request $request)
    {
        $request->validate([
            'pria_nama' => 'nullable|string|max:255',
            'pria_nama_lengkap' => 'nullable|string|max:255',
            'wanita_nama' => 'nullable|string|max:255',
            'wanita_nama_lengkap' => 'nullable|string|max:255',
        ]);

        $invitation = Auth::user()->invitation;
        if (!$invitation) {
            return response()->json(['error' => 'Data undangan tidak ditemukan.'], 404);
        }
        
        $invitation->update([
            'pria_nama' => $request->pria_nama,
            'pria_nama_lengkap' => $request->pria_nama_lengkap,
            'wanita_nama' => $request->wanita_nama,
            'wanita_nama_lengkap' => $request->wanita_nama_lengkap,
        ]);

        return response()->json(['success' => true]);
    }

    public function updateAcara(Request $request)
    {
        $request->validate([
            'akad_tgl' => 'nullable|date',
            'akad_mulai' => 'nullable|date_format:H:i',
            'akad_selesai' => 'nullable|date_format:H:i',
            'akad_lokasi' => 'nullable|string|max:255',
            'akad_alamat' => 'nullable|string',
            'akad_gmaps' => 'nullable|url',
            
            'resepsi_tgl' => 'nullable|date',
            'resepsi_mulai' => 'nullable|date_format:H:i',
            'resepsi_selesai' => 'nullable|date_format:H:i',
            'resepsi_lokasi' => 'nullable|string|max:255',
            'resepsi_alamat' => 'nullable|string',
            'resepsi_gmaps' => 'nullable|url',
        ]);

        $invitation = Auth::user()->invitation;
        if (!$invitation) {
            return response()->json(['error' => 'Data undangan tidak ditemukan.'], 404);
        }

        // Update or Create Akad
        $invitation->acaras()->updateOrCreate(
            ['tipe_acara' => 'akad'],
            [
                'tgl_acara' => $request->akad_tgl,
                'waktu_mulai' => $request->akad_mulai,
                'waktu_selesai' => $request->akad_selesai,
                'lokasi' => $request->akad_lokasi,
                'alamat' => $request->akad_alamat,
                'gmaps_link' => $request->akad_gmaps,
            ]
        );

        // Update or Create Resepsi
        $invitation->acaras()->updateOrCreate(
            ['tipe_acara' => 'resepsi'],
            [
                'tgl_acara' => $request->resepsi_tgl,
                'waktu_mulai' => $request->resepsi_mulai,
                'waktu_selesai' => $request->resepsi_selesai,
                'lokasi' => $request->resepsi_lokasi,
                'alamat' => $request->resepsi_alamat,
                'gmaps_link' => $request->resepsi_gmaps,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'status' => 'required|in:draft,trial,aktif,nonaktif',
            'music_file' => 'nullable|url',
        ]);

        $invitation = Auth::user()->invitation;
        if (!$invitation) {
            return response()->json(['error' => 'Data undangan tidak ditemukan.'], 404);
        }

        $invitation->update([
            'status' => $request->status,
            'music_file' => $request->music_file,
            'is_galeri_aktif' => $request->has('is_galeri_aktif'),
            'is_cerita_aktif' => $request->has('is_cerita_aktif'),
            'is_kado_aktif' => $request->has('is_kado_aktif'),
        ]);

        return response()->json(['success' => true, 'slug' => $invitation->slug]);
    }
}
