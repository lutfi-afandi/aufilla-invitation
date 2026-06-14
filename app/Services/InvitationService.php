<?php

namespace App\Services;

use App\Models\Invitation;
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
            // Use the provided username (which is already slugified by the controller/frontend)
            $username = Str::slug($data['username']);
            
            // Create the user
            $user = User::create([
                'username' => $username,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'client',
            ]);

            // Cari ID Paket VIP untuk Trial
            $vipPackage = \App\Models\Package::where('name', 'VIP')->first();
            $packageId = $vipPackage ? $vipPackage->id : null;

            $invitation = Invitation::create([
                'user_id' => $user->id,
                'theme_id' => $data['theme_id'] ?? null,
                'package_id' => $packageId,
                'slug' => $username,
                'status' => 'trial',
                'trial_habis_at' => Carbon::now()->addDay(),
                'pria_nama' => 'Pria',
                'wanita_nama' => 'Wanita',
            ]);

            return $user;
        });
    }
}
