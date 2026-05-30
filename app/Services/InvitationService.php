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
            // Generate a username from the couple's name
            $username = Str::slug($data['couple_name']) . rand(100, 999);
            
            // Create the user
            $user = User::create([
                'username' => $username,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'client',
            ]);

            // Create the invitation with a 1-day trial
            $slug = Str::slug($data['couple_name']);
            // Ensure unique slug
            $originalSlug = $slug;
            $count = 1;
            while (Invitation::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $invitation = Invitation::create([
                'user_id' => $user->id,
                'theme_id' => $data['theme_id'] ?? null,
                'slug' => $slug,
                'status' => 'trial',
                'trial_habis_at' => Carbon::now()->addDay(),
                'pria_nama' => 'Pria',
                'wanita_nama' => 'Wanita',
            ]);

            return $user;
        });
    }
}
