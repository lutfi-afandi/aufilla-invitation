<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function index()
    {
        $themes = Tema::withCount('undangans')->where('is_active', true)->get();
        $packages = Paket::orderBy('price', 'asc')->get();

        return view('landing.index', compact('themes', 'packages'));
    }

    public function register(Request $request)
    {
        $request->merge([
            'username' => Str::slug($request->username),
            'slug'     => Str::slug($request->slug ?: $request->username),
        ]);

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username',
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Username ini tidak bisa digunakan.');
                    }
                },
            ],
            'slug' => [
                'required',
                'string',
                'max:100',
                'unique:undangans,slug',
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('URL Slug ini tidak bisa digunakan.');
                    }
                },
            ],
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'theme_id' => 'required|exists:temas,id',
        ]);

        $user = User::create([
            'username'          => $validated['username'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'role'              => 'client',
            'email_verified_at' => now(),
        ]);

        $trialPaket = Paket::where('name', 'Trial')->first() ?? Paket::first();
        $activeDays = $trialPaket ? $trialPaket->active_days : 3;

        $user->undangans()->create([
            'slug'       => $validated['slug'],
            'tema_id'    => $validated['theme_id'],
            'paket_id'   => $trialPaket ? $trialPaket->id : null,
            'status'     => 'aktif',
            'expired_at' => now()->addDays($activeDays),
            'pria_nama'  => 'Pria',
            'wanita_nama' => 'Wanita',
        ]);

        Auth::login($user);

        return redirect()->route('client.dashboard')->with('success', 'Selamat datang! Akun Anda berhasil dibuat. Masa Trial ' . $activeDays . ' hari telah dimulai.');
    }
}
