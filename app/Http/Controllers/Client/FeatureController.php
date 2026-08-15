<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Galeri;
use App\Models\Cerita;
use App\Models\Kado;

class FeatureController extends Controller
{
    // ==========================================
    // GALERI FOTO
    // ==========================================
    public function storeGaleri(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:6144'
        ]);

        $undangan = Auth::user()->undangans()->first();
        if (!$undangan) {
            return response()->json(['error' => 'Undangan tidak ditemukan.'], 404);
        }

        $maxGaleris = $undangan->paket ? $undangan->paket->max_gallery_photos : 5;
        if ($undangan->galeris()->count() >= $maxGaleris) {
            return response()->json(['error' => 'Anda telah mencapai batas maksimal unggahan galeri untuk paket ini ('.$maxGaleris.' foto).'], 403);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galeri', 'public');
            
            $galeri = $undangan->galeris()->create([
                'image_path' => $path
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diunggah',
                'galeri' => $galeri
            ]);
        }

        return response()->json(['error' => 'Gagal mengunggah foto'], 500);
    }

    public function destroyGaleri($id)
    {
        $undangan = Auth::user()->undangans()->first();
        $galeri = $undangan->galeris()->findOrFail($id);

        if (Storage::disk('public')->exists($galeri->image_path)) {
            Storage::disk('public')->delete($galeri->image_path);
        }

        $galeri->delete();

        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus']);
    }

    // ==========================================
    // CERITA CINTA
    // ==========================================
    public function storeCerita(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'isi_cerita' => 'required|string'
        ]);

        $undangan = Auth::user()->undangans()->first();
        
        if (!$undangan->paket || !$undangan->paket->has_love_story) {
            return response()->json(['error' => 'Paket Anda tidak mendukung fitur Cerita Cinta.'], 403);
        }

        $cerita = $undangan->ceritas()->create([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'isi' => $request->isi_cerita
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cerita berhasil ditambahkan',
            'cerita' => $cerita
        ]);
    }

    public function updateCerita(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'isi_cerita' => 'required|string'
        ]);

        $undangan = Auth::user()->undangans()->first();
        $cerita = $undangan->ceritas()->findOrFail($id);

        $cerita->update([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'isi' => $request->isi_cerita
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cerita berhasil diperbarui',
            'cerita' => $cerita
        ]);
    }

    public function destroyCerita($id)
    {
        $undangan = Auth::user()->undangans()->first();
        $cerita = $undangan->ceritas()->findOrFail($id);
        $cerita->delete();

        return response()->json(['success' => true, 'message' => 'Cerita berhasil dihapus']);
    }

    // ==========================================
    // KADO DIGITAL
    // ==========================================
    public function updateAlamatKado(Request $request)
    {
        $request->validate([
            'alamat_kado' => 'required|string'
        ]);

        $undangan = Auth::user()->undangans()->first();
        $undangan->update([
            'alamat_kado' => $request->alamat_kado
        ]);

        return response()->json(['success' => true, 'message' => 'Alamat pengiriman berhasil diperbarui']);
    }

    public function storeKado(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            'no_rekening' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255'
        ]);

        $undangan = Auth::user()->undangans()->first();

        $kado = $undangan->kados()->create([
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'nama_pemilik' => $request->nama_pemilik
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rekening berhasil ditambahkan',
            'kado' => $kado
        ]);
    }

    public function destroyKado($id)
    {
        $undangan = Auth::user()->undangans()->first();
        $kado = $undangan->kados()->findOrFail($id);
        $kado->delete();

        return response()->json(['success' => true, 'message' => 'Rekening berhasil dihapus']);
    }
}
