<?php

namespace App\Services;

use App\Models\Undangan;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InvitationService
{
    /**
     * Handle quick registration from landing page.
     */
    public function quickRegister(array $data)
    {
        return DB::transaction(function () use ($data) {
            $username = Str::slug($data['username']);
            
            $user = User::create([
                'username' => $username,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'client',
            ]);

            $trialPaket = Paket::where('name', 'Trial')->first() ?? Paket::first();
            $activeDays = $trialPaket ? $trialPaket->active_days : 3;

            $invitation = Undangan::create([
                'user_id' => $user->id,
                'tema_id' => $data['theme_id'] ?? null,
                'paket_id' => $trialPaket ? $trialPaket->id : null,
                'slug' => $username,
                'status' => 'aktif',
                'expired_at' => Carbon::now()->addDays($activeDays),
                'pria_nama' => 'Pria',
                'wanita_nama' => 'Wanita',
            ]);

            return $user;
        });
    }
}
