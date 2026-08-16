<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Undangan;
use App\Models\Tema;

class PublicInvitationController extends Controller
{
    public function show($slug)
    {
        $invitation = Undangan::with(['user', 'tema', 'acaras', 'galeris', 'ucapans'])->where('slug', $slug)->firstOrFail();

        if (!$invitation->tema) {
            abort(404, 'Tema belum dikonfigurasi.');
        }

        // Cek status kedaluwarsa
        if ($invitation->status === 'kedaluwarsa' || $invitation->isExpired()) {
            abort(403, 'Masa aktif undangan ini telah habis. Silakan hubungi Admin/Pemilik untuk perpanjangan.');
        }

        $akad = $invitation->acaras->where('tipe_acara', 'akad')->first();
        $resepsi = $invitation->acaras->where('tipe_acara', 'resepsi')->first();
        $wishes = $invitation->ucapans()->orderBy('created_at', 'desc')->get();
        $maxGaleris = $invitation->paket ? $invitation->paket->max_gallery_photos : 5;
        $galeris = $invitation->galeris()->orderBy('created_at', 'desc')->limit($maxGaleris)->get();

        if ($invitation->paket && $invitation->paket->has_love_story) {
            $ceritas = $invitation->ceritas()->orderBy('created_at', 'asc')->get();
        } else {
            $ceritas = collect([]);
        }
        $kados = $invitation->kados()->orderBy('created_at', 'asc')->get();

        $viewPath = 'themes.' . $invitation->tema->code . '.index';

        if (!view()->exists($viewPath)) {
            abort(500, 'File tema (' . $invitation->tema->code . ') tidak ditemukan di server.');
        }

        $tamu = null;
        $qrCode = null;
        if (request()->has('to')) {
            $namaTamu = request()->query('to');
            $tamu = $invitation->tamus()->where('nama_tamu', $namaTamu)->first();
            if ($tamu && $tamu->kode_qr) {
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

        $invitation = Undangan::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'is_attending' => 'required|boolean',
            'message' => 'required|string',
        ]);

        $wish = $invitation->ucapans()->create([
            'nama' => $request->name,
            'kehadiran' => $request->is_attending ? 'hadir' : 'tidak_hadir',
            'ucapan' => $request->message,
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
        $theme = Tema::where('code', $themeCode)->firstOrFail();

        $viewPath = 'themes.' . $theme->code . '.index';
        if (!view()->exists($viewPath)) {
            abort(500, 'File tema (' . $theme->code . ') tidak ditemukan di server.');
        }

        $invitation = new Undangan([
            'slug' => 'preview',
            'pria_nama' => 'Bima',
            'pria_nama_lengkap' => 'Bima Saputra',
            'pria_ayah' => 'Bapak Saputra',
            'pria_ibu' => 'Ibu Saputra',
            'wanita_nama' => 'Ayu',
            'wanita_nama_lengkap' => 'Ayu Lestari',
            'wanita_ayah' => 'Bapak Lestari',
            'wanita_ibu' => 'Ibu Lestari',
            'kutipan_sumber' => 'QS. Ar-Rum: 21',
            'kutipan_teks' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya diantaramu rasa kasih dan sayang.',
            'is_galeri_aktif' => true,
            'is_cerita_aktif' => true,
            'is_kado_aktif' => true,
            'alamat_kado' => 'Jl. Cinta Sejati No. 12, Lampung',
            'music_file' => null,
        ]);
        $invitation->id = 9999;
        $invitation->setRelation('tema', $theme);

        $akad = new \App\Models\Acara([
            'tipe_acara' => 'akad',
            'nama_acara' => 'Akad Nikah',
            'tgl_acara' => now()->addDays(14)->format('Y-m-d'),
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '10:00',
            'lokasi' => 'Masjid Raya Verona',
            'alamat' => 'Jl. Masjid Raya No. 1',
        ]);

        $resepsi = new \App\Models\Acara([
            'tipe_acara' => 'resepsi',
            'nama_acara' => 'Resepsi Pernikahan',
            'tgl_acara' => now()->addDays(14)->format('Y-m-d'),
            'waktu_mulai' => '11:00',
            'waktu_selesai' => '14:00',
            'lokasi' => 'Gedung Serbaguna',
            'alamat' => 'Jl. Kebahagiaan No. 2',
        ]);

        $wishes = collect([
            new \App\Models\Ucapan([
                'nama' => 'Admin Aufilla',
                'kehadiran' => 'hadir',
                'ucapan' => 'Selamat menempuh hidup baru. Semoga menjadi keluarga yang sakinah, mawaddah, dan warahmah.',
                'created_at' => now(),
            ]),
        ]);

        $galeris = collect([
            new \App\Models\Galeri(['image_path' => 'assets/default/default-pasangan.jpg']),
            new \App\Models\Galeri(['image_path' => 'assets/default/default_pria.jpg']),
            new \App\Models\Galeri(['image_path' => 'assets/default/default_wanita.jpg']),
        ]);

        $ceritas = collect([
            new \App\Models\Cerita([
                'judul' => 'Awal Pertemuan',
                'tanggal' => '2022-08-14',
                'isi' => 'Tak ada yang menyangka, pertemuan sederhana di sebuah acara kampus menjadi awal dari kisah kami.'
            ]),
        ]);

        $kados = collect([
            new \App\Models\Kado(['nama_bank' => 'BCA', 'no_rekening' => '1234567890', 'nama_pemilik' => 'Bima Saputra']),
        ]);

        $tamu = new \App\Models\Tamu(['nama_tamu' => 'Tamu Spesial', 'kode_qr' => 'PREVIEW-QR-123']);
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->margin(2)->generate($tamu->kode_qr);

        return view($viewPath, compact('invitation', 'akad', 'resepsi', 'wishes', 'galeris', 'ceritas', 'kados', 'tamu', 'qrCode'));
    }
}
