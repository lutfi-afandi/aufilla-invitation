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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $invitation = Auth::user()->invitation;
        
        if (!\App\Helpers\PackageHelper::canAddGalleryPhoto($invitation)) {
            $max = \App\Helpers\PackageHelper::getMaxGalleryPhotos($invitation);
            return response()->json(['error' => 'Anda telah mencapai batas maksimal unggahan galeri untuk paket ini ('.$max.' foto).'], 403);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galeri', 'public');
            
            $galeri = $invitation->galeris()->create([
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
        $invitation = Auth::user()->invitation;
        $galeri = $invitation->galeris()->findOrFail($id);

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

        $invitation = Auth::user()->invitation;
        
        if (!\App\Helpers\PackageHelper::canAccessLoveStory($invitation)) {
            return response()->json(['error' => 'Paket Anda tidak mendukung fitur Cerita Cinta.'], 403);
        }

        $cerita = $invitation->ceritas()->create([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'isi_cerita' => $request->isi_cerita
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

        $invitation = Auth::user()->invitation;
        $cerita = $invitation->ceritas()->findOrFail($id);

        $cerita->update([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'isi_cerita' => $request->isi_cerita
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cerita berhasil diperbarui',
            'cerita' => $cerita
        ]);
    }

    public function destroyCerita($id)
    {
        $invitation = Auth::user()->invitation;
        $cerita = $invitation->ceritas()->findOrFail($id);
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

        $invitation = Auth::user()->invitation;
        $invitation->update([
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

        $invitation = Auth::user()->invitation;

        $kado = $invitation->kados()->create([
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
        $invitation = Auth::user()->invitation;
        $kado = $invitation->kados()->findOrFail($id);
        $kado->delete();

        return response()->json(['success' => true, 'message' => 'Rekening berhasil dihapus']);
    }
}
