<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function index()
    {
        $themes = Tema::withCount('undangans')
            ->where('is_active', true)
            ->where('is_privat', false)
            ->get();
        
        $categories = \App\Models\KategoriTema::where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->get();

        // Paid packages only for main pricing grid
        $packages = Paket::where('name', '!=', 'Trial')->orderBy('price', 'asc')->get();

        // Trial package info for promo banner
        $trialPaket = Paket::where('name', 'Trial')->first();

        return view('landing.index', compact('themes', 'categories', 'packages', 'trialPaket'));
    }

    public function showRegisterForm(Request $request)
    {
        $themes = Tema::where('is_active', true)
            ->where('is_privat', false)
            ->get();
            
        $categories = \App\Models\KategoriTema::where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->get();

        $selectedThemeCode = $request->query('theme');
        $selectedTheme = null;

        if ($selectedThemeCode) {
            $selectedTheme = Tema::where('code', $selectedThemeCode)
                ->where('is_active', true)
                ->where('is_privat', false)
                ->first();
        }

        if (!$selectedTheme) {
            $selectedTheme = $themes->first();
        }

        return view('landing.register', compact('themes', 'categories', 'selectedTheme'));
    }

    public function register(Request $request)
    {
        $request->merge([
            'username' => Str::slug($request->username),
            'slug' => Str::slug($request->slug ?: ($request->pria_nama.'-'.$request->wanita_nama)),
        ]);

        $validated = $request->validate([
            'pria_nama' => 'required|string|max:50',
            'pria_nama_lengkap' => 'nullable|string|max:150',
            'wanita_nama' => 'required|string|max:50',
            'wanita_nama_lengkap' => 'nullable|string|max:150',
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username',
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu', 'buat-undangan'];
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
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu', 'buat-undangan'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('URL Slug link undangan ini tidak dapat digunakan.');
                    }
                },
            ],
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'theme_id' => 'required|exists:temas,id',
        ], [
            'pria_nama.required' => 'Nama panggilan pengantin pria wajib diisi.',
            'wanita_nama.required' => 'Nama panggilan pengantin wanita wajib diisi.',
            'username.required' => 'Username untuk login wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan oleh akun lain.',
            'slug.required' => 'Link URL kustom undangan wajib diisi.',
            'slug.unique' => 'Link URL kustom undangan ini sudah digunakan. Silakan gunakan link yang berbeda.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'theme_id.required' => 'Tema undangan wajib dipilih.',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        $trialPaket = Paket::where('name', 'Trial')->first() ?? Paket::first();
        $activeDays = $trialPaket ? $trialPaket->active_days : 3;

        $user->undangans()->create([
            'slug' => $validated['slug'],
            'tema_id' => $validated['theme_id'],
            'paket_id' => $trialPaket ? $trialPaket->id : null,
            'status' => 'aktif',
            'is_galeri_aktif' => false,
            'is_cerita_aktif' => false,
            'is_kado_aktif' => false,
            'expired_at' => now()->addDays($activeDays),
            'pria_nama' => $validated['pria_nama'],
            'pria_nama_lengkap' => $validated['pria_nama_lengkap'] ?? $validated['pria_nama'],
            'wanita_nama' => $validated['wanita_nama'],
            'wanita_nama_lengkap' => $validated['wanita_nama_lengkap'] ?? $validated['wanita_nama'],
        ]);

        Auth::login($user);

        return redirect()->route('client.dashboard')->with('success', 'Selamat datang! Undangan Anda berhasil dibuat. Masa Trial '.$activeDays.' hari telah dimulai.');
    }
}
