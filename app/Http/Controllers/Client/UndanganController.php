<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Undangan;
use App\Models\User;

class UndanganController extends Controller
{
    public function updateMempelai(Request $request)
    {
        $request->validate([
            'pria_nama' => 'nullable|string|max:255',
            'pria_nama_lengkap' => 'nullable|string|max:255',
            'pria_ayah' => 'nullable|string|max:255',
            'pria_ibu' => 'nullable|string|max:255',
            'pria_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:6144',
            
            'wanita_nama' => 'nullable|string|max:255',
            'wanita_nama_lengkap' => 'nullable|string|max:255',
            'wanita_ayah' => 'nullable|string|max:255',
            'wanita_ibu' => 'nullable|string|max:255',
            'wanita_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:6144',
            
            'cover_img' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:6144',
        ]);

        $undangan = Auth::user()->undangans()->first();
        if (!$undangan) {
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

        if ($request->hasFile('pria_foto')) {
            if ($undangan->pria_foto && Storage::disk('public')->exists($undangan->pria_foto)) {
                Storage::disk('public')->delete($undangan->pria_foto);
            }
            $updateData['pria_foto'] = $request->file('pria_foto')->store('pengantin', 'public');
        }

        if ($request->hasFile('wanita_foto')) {
            if ($undangan->wanita_foto && Storage::disk('public')->exists($undangan->wanita_foto)) {
                Storage::disk('public')->delete($undangan->wanita_foto);
            }
            $updateData['wanita_foto'] = $request->file('wanita_foto')->store('pengantin', 'public');
        }

        if ($request->hasFile('cover_img')) {
            if ($undangan->cover_img && Storage::disk('public')->exists($undangan->cover_img)) {
                Storage::disk('public')->delete($undangan->cover_img);
            }
            $updateData['cover_img'] = $request->file('cover_img')->store('pengantin', 'public');
        }

        $undangan->update($updateData);

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

        $undangan = Auth::user()->undangans()->first();
        if (!$undangan) {
            return response()->json(['error' => 'Data undangan tidak ditemukan.'], 404);
        }

        $undangan->acaras()->updateOrCreate(
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

        $undangan->acaras()->updateOrCreate(
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
            'slug' => 'nullable|string|max:50',
            'music_file' => 'nullable|file|mimes:mp3,wav|max:10240',
            'kutipan_sumber' => 'nullable|string|max:100',
            'kutipan_teks' => 'nullable|string|max:1000',
        ]);

        $undangan = Auth::user()->undangans()->first();
        if (!$undangan) {
            return response()->json(['error' => 'Data undangan tidak ditemukan.'], 404);
        }

        $canCerita = $undangan->paket ? $undangan->paket->has_love_story : false;
        $canMusic = $undangan->paket ? $undangan->paket->can_custom_music : false;

        if ($request->has('is_cerita_aktif') && !$canCerita) {
            return response()->json(['error' => 'Paket Anda tidak mendukung fitur Cerita Cinta.'], 403);
        }

        if ($request->hasFile('music_file') && !$canMusic) {
            return response()->json(['error' => 'Paket Anda tidak mendukung kustomisasi musik latar.'], 403);
        }

        $updateData = [
            'is_galeri_aktif' => $request->has('is_galeri_aktif'),
            'is_cerita_aktif' => $canCerita ? $request->has('is_cerita_aktif') : false,
            'is_kado_aktif' => $request->has('is_kado_aktif'),
            'kutipan_sumber' => $request->input('kutipan_sumber'),
            'kutipan_teks' => $request->input('kutipan_teks'),
        ];

        if ($request->filled('slug')) {
            $newSlug = Str::slug($request->slug);
            $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
            if (in_array($newSlug, $reserved)) {
                return response()->json(['error' => 'URL custom ini tidak dapat digunakan.'], 422);
            }

            $existsUndangan = Undangan::where('slug', $newSlug)->where('id', '!=', $undangan->id)->exists();
            $existsUser = User::where('username', $newSlug)->where('id', '!=', Auth::id())->exists();

            if ($existsUndangan || $existsUser) {
                return response()->json(['error' => 'URL custom / link ini sudah digunakan oleh akun lain.'], 422);
            }

            $updateData['slug'] = $newSlug;
        }

        if ($request->hasFile('music_file')) {
            if ($undangan->music_file && Storage::disk('public')->exists($undangan->music_file)) {
                Storage::disk('public')->delete($undangan->music_file);
            }
            $updateData['music_file'] = $request->file('music_file')->store('music', 'public');
        }

        $undangan->update($updateData);

        return response()->json(['success' => true, 'slug' => $undangan->slug]);
    }
}
