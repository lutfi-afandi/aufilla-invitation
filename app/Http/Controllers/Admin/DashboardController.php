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
        return view('admin.dashboard', [
            'totalClients'       => User::where('role', 'client')->count(),
            'activeInvitations'  => Invitation::where('status', 'aktif')->count(),
            'trialInvitations'   => Invitation::where('status', 'trial')->count(),
            'draftInvitations'   => Invitation::where('status', 'draft')->count(),
            'nonaktifInvitations'=> Invitation::where('status', 'nonaktif')->count(),
            'totalGuests'        => Tamu::count(),
            'totalUcapan'        => Ucapan::count(),
            'recentUcapans'      => Ucapan::with('invitation')->latest()->take(5)->get(),
        ]);
    }
}
