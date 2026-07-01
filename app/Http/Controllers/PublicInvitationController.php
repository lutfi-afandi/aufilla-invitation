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

        // Cek apakah data pengantin sudah lengkap
        if (!$invitation->isDataPengantinComplete()) {
            abort(403, 'Undangan belum bisa diakses karena Data Pengantin belum lengkap. Jika Anda pemilik undangan, silakan lengkapi profil mempelai melalui Panel Klien.');
        }

        // Cek apakah data acara sudah lengkap
        if (!$invitation->isDataAcaraComplete()) {
            abort(403, 'Undangan belum bisa diakses karena Data Acara belum lengkap. Jika Anda pemilik undangan, silakan lengkapi data acara (Akad & Resepsi) melalui Panel Klien.');
        }

        // If trial expired, blocked completely for everyone
        if ($invitation->status === 'trial' && $invitation->trial_habis_at && $invitation->trial_habis_at->isPast()) {
            abort(403, 'Masa trial undangan ini telah habis. Silakan hubungi Admin untuk aktivasi.');
        }

        // If nonaktif
        if ($invitation->status === 'nonaktif') {
            abort(404, 'Undangan ini sedang tidak aktif.');
        }

        $akad = $invitation->acaras->where('tipe_acara', 'akad')->first();
        $resepsi = $invitation->acaras->where('tipe_acara', 'resepsi')->first();
        $wishes = $invitation->ucapans()->orderBy('created_at', 'desc')->get(); // Fetch wishes
        $maxGaleris = \App\Helpers\PackageHelper::getMaxGalleryPhotos($invitation);
        $galeris = $invitation->galeris()->orderBy('created_at', 'desc')->limit($maxGaleris)->get();

        if (\App\Helpers\PackageHelper::canAccessLoveStory($invitation)) {
            $ceritas = $invitation->ceritas()->orderBy('created_at', 'asc')->get();
        } else {
            $ceritas = collect([]);
        }
        $kados = $invitation->kados()->orderBy('created_at', 'asc')->get();

        // Dynamically load the view based on the theme code
        $viewPath = 'themes.' . $invitation->theme->code . '.index';

        if (!view()->exists($viewPath)) {
            abort(500, 'File tema (' . $invitation->theme->code . ') tidak ditemukan di server.');
        }

        // Handle Guest and QR Code
        $tamu = null;
        $qrCode = null;
        if (request()->has('to')) {
            $namaTamu = request()->query('to');
            $tamu = $invitation->tamus()->where('nama_tamu', $namaTamu)->first();
            if ($tamu) {
                // Generate QR Code containing the Tamu Kode QR
                $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->margin(2)->generate($tamu->kode_qr);
            }
        }

        return view($viewPath, compact('invitation', 'akad', 'resepsi', 'wishes', 'galeris', 'ceritas', 'kados', 'tamu', 'qrCode'));
    }

    public function storeUcapan(Request $request, $slug)
    {
        if ($slug === 'preview') {
            return response()->json([
                'message' => 'Konfirmasi berhasil dikirim (Mode Preview)!',
                'wish' => [
                    'nama' => $request->name,
                    'created_at' => \Carbon\Carbon::now()
                ]
            ]);
        }

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

    public function preview($themeCode)
    {
        $theme = \App\Models\Theme::where('code', $themeCode)->firstOrFail();

        $viewPath = 'themes.' . $theme->code . '.index';
        if (!view()->exists($viewPath)) {
            abort(500, 'File tema (' . $theme->code . ') tidak ditemukan di server.');
        }

        // Generate Dummy Data for Preview
        $invitation = new Invitation([
            'slug' => 'preview',
            'pria_nama' => 'Romeo',
            'pria_nama_lengkap' => 'Romeo Montague',
            'pria_ayah' => 'Bapak Montague',
            'pria_ibu' => 'Ibu Montague',
            'wanita_nama' => 'Juliet',
            'wanita_nama_lengkap' => 'Juliet Capulet',
            'wanita_ayah' => 'Bapak Capulet',
            'wanita_ibu' => 'Ibu Capulet',
            'is_galeri_aktif' => true,
            'is_cerita_aktif' => true,
            'is_kado_aktif' => true,
            'alamat_kado' => 'Jl. Cinta Sejati No. 12, Lampung',
            'music_file' => null,
        ]);

        // Relationship mock (this might not be perfect for all eloquent relations but works for standard property access)
        $invitation->setRelation('theme', $theme);

        $akad = new \App\Models\Acara([
            'tipe_acara' => 'akad',
            'nama_acara' => 'Akad Nikah',
            'tgl_acara' => now()->addDays(14)->format('Y-m-d'),
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '10:00',
            'tempat' => 'Masjid Raya Verona',
            'alamat' => 'Jl. Masjid Raya No. 1',
        ]);

        $resepsi = new \App\Models\Acara([
            'tipe_acara' => 'resepsi',
            'nama_acara' => 'Resepsi Pernikahan',
            'tgl_acara' => now()->addDays(14)->format('Y-m-d'),
            'waktu_mulai' => '11:00',
            'waktu_selesai' => '14:00',
            'tempat' => 'Gedung Serbaguna',
            'alamat' => 'Jl. Kebahagiaan No. 2',
        ]);

        $wish1 = new \App\Models\Ucapan(['nama' => 'Admin Aufilla', 'kehadiran' => 'hadir', 'pesan' => 'Selamat menempuh hidup baru!']);
        $wish1->created_at = now();
        $wish2 = new \App\Models\Ucapan(['nama' => 'Fulan', 'kehadiran' => 'hadir', 'pesan' => 'Semoga samawa ya!']);
        $wish2->created_at = now()->subHours(2);

        $wishes = collect([$wish1, $wish2]);

        $galeris = collect([
            new \App\Models\Galeri(['image_path' => 'assets/default/default-pasangan.jpg']),
            new \App\Models\Galeri(['image_path' => 'assets/default/default_pria.jpg']),
            new \App\Models\Galeri(['image_path' => 'assets/default/default_wanita.jpg']),
            new \App\Models\Galeri(['image_path' => 'assets/default/default-pasangan2.jpg']),
            new \App\Models\Galeri(['image_path' => 'assets/default/default_pria2.jpg']),
            new \App\Models\Galeri(['image_path' => 'assets/default/default_wanita2.jpg']),
        ]);
        $ceritas = collect([
            new \App\Models\Cerita(['judul' => 'Pertama Bertemu', 'tanggal' => '2023-01-10', 'isi_cerita' => 'Kami pertama kali bertemu di sebuah cafe.']),
            new \App\Models\Cerita(['judul' => 'Lamaran', 'tanggal' => '2024-05-20', 'isi_cerita' => 'Dia melamar saya di pantai.'])
        ]);

        $kados = collect([
            new \App\Models\Kado(['nama_bank' => 'BCA', 'nomor_rekening' => '1234567890', 'atas_nama' => 'Romeo Montague']),
            new \App\Models\Kado(['nama_bank' => 'Muamalat', 'nomor_rekening' => '089345092832', 'atas_nama' => 'Juliet Capulet']),
        ]);

        $tamu = new \App\Models\Tamu(['nama_tamu' => 'Tamu Spesial', 'kode_qr' => 'PREVIEW-QR-123']);
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->margin(2)->generate($tamu->kode_qr);

        return view($viewPath, compact('invitation', 'akad', 'resepsi', 'wishes', 'galeris', 'ceritas', 'kados', 'tamu', 'qrCode'));
    }
}
