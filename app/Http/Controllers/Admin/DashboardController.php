<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Tamu;
use App\Models\Ucapan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = User::where('role', 'client')->count();
        $activeInvitations = Invitation::where('status', 'active')->count();
        $trialInvitations = Invitation::where('status', 'trial')->count();
        $expiredInvitations = Invitation::where('status', 'expired')->count();
        $totalInvitations = $activeInvitations + $trialInvitations + $expiredInvitations;

        // Persentase untuk progress bar visual
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
            'recentUcapans'      => Ucapan::with('invitation')->latest()->take(5)->get(),
        ]);
    }
}
