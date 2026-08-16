<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Undangan;
use App\Models\Tema;
use App\Models\Paket;
use App\Models\Ucapan;
use App\Helpers\PackageHelper;

class DashboardController extends Controller
{
    private function getUndangan()
    {
        $user = auth()->user();
        $undangan = $user->undangans()->first();

        if (!$undangan) {
            $trialPaket = Paket::where('name', 'Trial')->first() ?? Paket::first();
            $activeDays = $trialPaket ? $trialPaket->active_days : 3;

            $undangan = $user->undangans()->create([
                'slug' => $user->username . '-' . uniqid(),
                'tema_id' => Tema::first()?->id,
                'paket_id' => $trialPaket?->id,
                'status' => 'aktif',
                'is_galeri_aktif' => false,
                'is_cerita_aktif' => false,
                'is_kado_aktif' => false,
                'expired_at' => now()->addDays($activeDays),
            ]);
        }

        return $undangan;
    }

    public function index()
    {
        $invitation = $this->getUndangan();
        $recentUcapans = Ucapan::where('undangan_id', $invitation->id)->latest()->take(5)->get();

        $akad = $invitation->acaras()->where('tipe_acara', 'akad')->first();
        $resepsi = $invitation->acaras()->where('tipe_acara', 'resepsi')->first();

        // Check completion of required items
        $hasPengantin = !empty($invitation->pria_nama) && !empty($invitation->wanita_nama) && $invitation->pria_nama !== 'Pria';
        $hasAkad = $akad && !empty($akad->tgl_acara) && !empty($akad->lokasi);
        $hasResepsi = $resepsi && !empty($resepsi->tgl_acara) && !empty($resepsi->lokasi);
        $hasAcara = $hasAkad || $hasResepsi;
        $hasSlug = !empty($invitation->slug);
        
        $checklistItems = [
            'pengantin' => [
                'title' => 'Data Pengantin (Mempelai)',
                'desc' => 'Nama panggilan & nama lengkap pengantin pria dan wanita',
                'is_completed' => $hasPengantin,
                'route' => route('client.pengantin'),
                'button_text' => 'Isi Data Mempelai',
                'icon' => 'user-group',
            ],
            'acara' => [
                'title' => 'Data Acara (Akad & Resepsi)',
                'desc' => 'Tanggal, jam pelaksanaan, nama lokasi & alamat lokasi',
                'is_completed' => $hasAcara,
                'route' => route('client.acara'),
                'button_text' => 'Atur Tanggal & Lokasi',
                'icon' => 'calendar',
            ],
            'pengaturan' => [
                'title' => 'Link Undangan & Musik',
                'desc' => 'Kustomisasi URL link undangan & lagu musik latar',
                'is_completed' => $hasSlug,
                'route' => route('client.pengaturan'),
                'button_text' => 'Kelola Link & Musik',
                'icon' => 'cog',
            ],
        ];

        // Optional modules if active
        if ($invitation->is_cerita_aktif && PackageHelper::canAccessLoveStory($invitation)) {
            $checklistItems['cerita'] = [
                'title' => 'Cerita Cinta (Love Story)',
                'desc' => 'Rangkaian kisah momen berkesan perjalanan cinta',
                'is_completed' => $invitation->ceritas()->count() > 0,
                'route' => route('client.cerita'),
                'button_text' => 'Kelola Cerita Cinta',
                'icon' => 'heart',
            ];
        }

        if ($invitation->is_galeri_aktif && PackageHelper::getMaxGalleryPhotos($invitation) > 0) {
            $checklistItems['galeri'] = [
                'title' => 'Galeri Foto Prewedding',
                'desc' => 'Unggah foto-foto kenangan momen bahagia',
                'is_completed' => $invitation->galeris()->count() > 0,
                'route' => route('client.galeri'),
                'button_text' => 'Unggah Foto Galeri',
                'icon' => 'photograph',
            ];
        }

        if ($invitation->is_kado_aktif) {
            $checklistItems['kado'] = [
                'title' => 'Kado Digital & Bank',
                'desc' => 'Rekening transfer bank/e-wallet & alamat kirim kado',
                'is_completed' => $invitation->kados()->count() > 0,
                'route' => route('client.kado'),
                'button_text' => 'Kelola Rekening Kado',
                'icon' => 'gift',
            ];
        }

        $totalChecklist = count($checklistItems);
        $completedChecklist = count(array_filter($checklistItems, fn($item) => $item['is_completed']));
        $readinessPercentage = round(($completedChecklist / $totalChecklist) * 100);
        $isReadyToShare = $hasPengantin && $hasAcara;

        return view('client.dashboard', compact(
            'invitation',
            'recentUcapans',
            'checklistItems',
            'totalChecklist',
            'completedChecklist',
            'readinessPercentage',
            'isReadyToShare'
        ));
    }

    public function pengantin()
    {
        $invitation = $this->getUndangan();
        return view('client.pengantin', compact('invitation'));
    }

    public function acara()
    {
        $invitation = $this->getUndangan();
        $akad = $invitation->acaras()->where('tipe_acara', 'akad')->first();
        $resepsi = $invitation->acaras()->where('tipe_acara', 'resepsi')->first();

        return view('client.acara', compact('invitation', 'akad', 'resepsi'));
    }

    public function tamu()
    {
        $invitation = $this->getUndangan();
        return view('client.tamu', compact('invitation'));
    }

    public function pengaturan()
    {
        $invitation = $this->getUndangan();
        return view('client.pengaturan', compact('invitation'));
    }

    public function galeri()
    {
        $invitation = $this->getUndangan();

        if (PackageHelper::getMaxGalleryPhotos($invitation) <= 0 || !$invitation->is_galeri_aktif) {
            return redirect()->route('client.pengaturan')->with('warning', 'Modul Galeri Foto tidak aktif atau tidak didukung oleh paket Anda.');
        }

        $galeris = $invitation->galeris()->orderBy('created_at', 'desc')->get();
        return view('client.galeri', compact('invitation', 'galeris'));
    }

    public function cerita()
    {
        $invitation = $this->getUndangan();

        if (!PackageHelper::canAccessLoveStory($invitation) || !$invitation->is_cerita_aktif) {
            return redirect()->route('client.pengaturan')->with('warning', 'Modul Cerita Cinta tidak aktif atau tidak didukung oleh paket Anda.');
        }

        $ceritas = $invitation->ceritas()->orderBy('created_at', 'asc')->get();
        return view('client.cerita', compact('invitation', 'ceritas'));
    }

    public function kado()
    {
        $invitation = $this->getUndangan();

        if (!$invitation->is_kado_aktif) {
            return redirect()->route('client.pengaturan')->with('warning', 'Modul Kado Digital tidak aktif.');
        }

        $kados = $invitation->kados()->orderBy('created_at', 'asc')->get();
        return view('client.kado', compact('invitation', 'kados'));
    }

    public function tutorial()
    {
        $invitation = $this->getUndangan();
        return view('client.tutorial', compact('invitation'));
    }
}
