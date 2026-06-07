<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function getInvitation()
    {
        $user = auth()->user();
        $invitation = $user->invitation;

        if (!$invitation) {
            $invitation = $user->invitation()->create([
                'slug' => $user->username . '-' . uniqid(),
                'theme_id' => \App\Models\Theme::first()->id ?? null,
                'status' => 'trial',
                'trial_habis_at' => now()->addDay(),
            ]);
        }

        return $invitation;
    }

    public function index()
    {
        $invitation = $this->getInvitation();
        return view('client.dashboard', compact('invitation'));
    }

    public function pengantin()
    {
        $invitation = $this->getInvitation();
        return view('client.pengantin', compact('invitation'));
    }

    public function acara()
    {
        $invitation = $this->getInvitation();
        $akad = $invitation->acaras()->where('tipe_acara', 'akad')->first();
        $resepsi = $invitation->acaras()->where('tipe_acara', 'resepsi')->first();

        return view('client.acara', compact('invitation', 'akad', 'resepsi'));
    }

    public function tamu()
    {
        $invitation = $this->getInvitation();
        return view('client.tamu', compact('invitation'));
    }

    public function pengaturan()
    {
        $invitation = $this->getInvitation();
        return view('client.pengaturan', compact('invitation'));
    }

    public function galeri()
    {
        $invitation = $this->getInvitation();
        $galeris = $invitation->galeris()->orderBy('created_at', 'desc')->get();
        return view('client.galeri', compact('invitation', 'galeris'));
    }

    public function cerita()
    {
        $invitation = $this->getInvitation();
        $ceritas = $invitation->ceritas()->orderBy('created_at', 'asc')->get();
        return view('client.cerita', compact('invitation', 'ceritas'));
    }

    public function kado()
    {
        $invitation = $this->getInvitation();
        $kados = $invitation->kados()->orderBy('created_at', 'asc')->get();
        return view('client.kado', compact('invitation', 'kados'));
    }
}
