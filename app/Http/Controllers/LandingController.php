<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function index()
    {
        $themes = Theme::withCount('invitations')->where('is_active', true)
            // ->take(6)
            ->get();
        $packages = Package::orderBy('price', 'asc')->get();

        return view('landing.index', compact('themes', 'packages'));
    }

    public function register(Request $request)
    {
        $request->merge([
            'username' => Str::slug($request->username)
        ]);

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username',
                'unique:invitations,slug',
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Username ini tidak bisa digunakan.');
                    }
                },
            ],
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'theme_id' => 'required|exists:themes,id',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'client',
        ]);

        $user->invitation()->create([
            'slug' => $validated['username'],
            'theme_id' => $validated['theme_id'],
            'status' => 'trial',
            'package_id' => 3,
            'trial_habis_at' => now()->addDay(),
            'pria_nama' => 'Pria',
            'wanita_nama' => 'Wanita',
        ]);

        Auth::login($user);

        return redirect()->route('client.dashboard')->with('success', 'Selamat datang! Akun Anda berhasil dibuat. Masa Trial 24 Jam telah dimulai.');
    }
}
