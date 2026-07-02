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
            'pria_ayah' => 'nullable|string|max:255',
            'pria_ibu' => 'nullable|string|max:255',
            'pria_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            
            'wanita_nama' => 'nullable|string|max:255',
            'wanita_nama_lengkap' => 'nullable|string|max:255',
            'wanita_ayah' => 'nullable|string|max:255',
            'wanita_ibu' => 'nullable|string|max:255',
            'wanita_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            
            'cover_img' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $invitation = Auth::user()->invitation;
        if (!$invitation) {
            return response()->json(['error' => 'Data undangan tidak ditemukan.'], 404);
        }
        
        $updateData = [
            'pria_nama' => $request->pria_nama,
            'pria_nama_lengkap' => $request->pria_nama_lengkap,
            'pria_ayah' => $request->pria_ayah,
            'pria_ibu' => $request->pria_ibu,
            
            'wanita_nama' => $request->wanita_nama,
            'wanita_nama_lengkap' => $request->wanita_nama_lengkap,
            'wanita_ayah' => $request->wanita_ayah,
            'wanita_ibu' => $request->wanita_ibu,
        ];

        // Handle File Uploads
        if ($request->hasFile('pria_foto')) {
            if ($invitation->pria_foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($invitation->pria_foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($invitation->pria_foto);
            }
            $updateData['pria_foto'] = $request->file('pria_foto')->store('pengantin', 'public');
        }

        if ($request->hasFile('wanita_foto')) {
            if ($invitation->wanita_foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($invitation->wanita_foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($invitation->wanita_foto);
            }
            $updateData['wanita_foto'] = $request->file('wanita_foto')->store('pengantin', 'public');
        }

        if ($request->hasFile('cover_img')) {
            if ($invitation->cover_img && \Illuminate\Support\Facades\Storage::disk('public')->exists($invitation->cover_img)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($invitation->cover_img);
            }
            $updateData['cover_img'] = $request->file('cover_img')->store('pengantin', 'public');
        }

        $invitation->update($updateData);

        return response()->json(['success' => true]);
    }

    public function updateAcara(Request $request)
    {
        $request->validate([
            'akad_nama' => 'nullable|string|max:100',
            'akad_tgl' => 'nullable|date',
            'akad_mulai' => 'nullable|date_format:H:i',
            'akad_selesai' => 'nullable|date_format:H:i',
            'akad_lokasi' => 'nullable|string|max:255',
            'akad_alamat' => 'nullable|string',
            'akad_gmaps' => 'nullable|url',
            
            'resepsi_nama' => 'nullable|string|max:100',
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
                'nama_acara' => $request->akad_nama,
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
                'nama_acara' => $request->resepsi_nama,
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
            'music_file' => 'nullable|file|mimes:mp3,wav|max:10240', // Max 10MB
            'kutipan_sumber' => 'nullable|string|max:100',
            'kutipan_teks' => 'nullable|string|max:1000',
        ]);

        $invitation = Auth::user()->invitation;
        if (!$invitation) {
            return response()->json(['error' => 'Data undangan tidak ditemukan.'], 404);
        }

        $canCerita = \App\Helpers\PackageHelper::canAccessLoveStory($invitation);
        $canMusic = \App\Helpers\PackageHelper::canAccessCustomMusic($invitation);

        if ($request->has('is_cerita_aktif') && !$canCerita) {
            return response()->json(['error' => 'Paket Anda tidak mendukung fitur Cerita Cinta.'], 403);
        }

        if ($request->hasFile('music_file') && !$canMusic) {
            if (\App\Helpers\PackageHelper::isTrial($invitation)) {
                return response()->json(['error' => 'Anda tidak dapat mengubah musik latar dalam mode Trial.'], 403);
            }
            return response()->json(['error' => 'Paket Anda tidak mendukung kustomisasi musik latar.'], 403);
        }

        $updateData = [
            'is_galeri_aktif' => $request->has('is_galeri_aktif'),
            'is_cerita_aktif' => $canCerita ? $request->has('is_cerita_aktif') : false,
            'is_kado_aktif' => $request->has('is_kado_aktif'),
            'kutipan_sumber' => $request->input('kutipan_sumber'),
            'kutipan_teks' => $request->input('kutipan_teks'),
        ];

        if ($request->hasFile('music_file')) {
            if ($invitation->music_file && \Illuminate\Support\Facades\Storage::disk('public')->exists($invitation->music_file)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($invitation->music_file);
            }
            $updateData['music_file'] = $request->file('music_file')->store('music', 'public');
        }

        $invitation->update($updateData);

        return response()->json(['success' => true, 'slug' => $invitation->slug]);
    }
}
