<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Undangan;
use App\Models\Tema;
use App\Models\Paket;
use App\Models\Ucapan;

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
                'expired_at' => now()->addDays($activeDays),
            ]);
        }

        return $undangan;
    }

    public function index()
    {
        $invitation = $this->getUndangan();
        $recentUcapans = Ucapan::where('undangan_id', $invitation->id)->latest()->take(5)->get();
        return view('client.dashboard', compact('invitation', 'recentUcapans'));
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
        $galeris = $invitation->galeris()->orderBy('created_at', 'desc')->get();
        return view('client.galeri', compact('invitation', 'galeris'));
    }

    public function cerita()
    {
        $invitation = $this->getUndangan();
        $ceritas = $invitation->ceritas()->orderBy('created_at', 'asc')->get();
        return view('client.cerita', compact('invitation', 'ceritas'));
    }

    public function kado()
    {
        $invitation = $this->getUndangan();
        $kados = $invitation->kados()->orderBy('created_at', 'asc')->get();
        return view('client.kado', compact('invitation', 'kados'));
    }

    public function tutorial()
    {
        $invitation = $this->getUndangan();
        return view('client.tutorial', compact('invitation'));
    }
}
