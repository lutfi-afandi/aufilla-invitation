<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Undangan;
use App\Models\Tamu;
use App\Models\Ucapan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = User::where('role', 'client')->count();
        $activeInvitations = Undangan::where('status', 'aktif')->count();
        $trialInvitations = Undangan::whereHas('paket', fn($q) => $q->where('name', 'Trial'))->where('status', 'aktif')->count();
        $expiredInvitations = Undangan::where('status', 'kedaluwarsa')->count();
        $totalInvitations = Undangan::count();

        $pctActive = $totalInvitations > 0 ? round(($activeInvitations / $totalInvitations) * 100) : 0;
        $pctTrial = $totalInvitations > 0 ? round(($trialInvitations / $totalInvitations) * 100) : 0;
        $pctExpired = $totalInvitations > 0 ? round(($expiredInvitations / $totalInvitations) * 100) : 0;

        return view('admin.dashboard', [
            'totalClients'       => $totalClients,
            'activeInvitations'  => $activeInvitations,
            'trialInvitations'   => $trialInvitations,
            'expiredInvitations' => $expiredInvitations,
            'totalInvitations'   => $totalInvitations,
            'pctActive'          => $pctActive,
            'pctTrial'           => $pctTrial,
            'pctExpired'         => $pctExpired,
            'totalGuests'        => Tamu::count(),
            'totalUcapan'        => Ucapan::count(),
            'recentUcapans'      => Ucapan::with('undangan')->latest()->take(5)->get(),
        ]);
    }
}
