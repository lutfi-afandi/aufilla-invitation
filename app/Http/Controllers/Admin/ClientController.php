<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Undangan;
use App\Models\Tema;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients  = User::where('role', 'client')
            ->with(['undangans.tema', 'undangans.paket'])
            ->latest()
            ->get();
            
        $themes   = Tema::where('is_active', true)->get();
        $packages = Paket::all();

        return view('admin.clients.index', compact('clients', 'themes', 'packages'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'username' => Str::slug($request->username),
            'slug'     => Str::slug($request->slug ?: $request->username),
        ]);

        $validated = $request->validate([
            'username'   => [
                'required', 'string', 'max:50', 'unique:users,username',
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Username ini tidak bisa digunakan.');
                    }
                }
            ],
            'slug'       => [
                'required', 'string', 'max:100', 'unique:undangans,slug',
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('URL slug ini tidak bisa digunakan.');
                    }
                }
            ],
            'email'      => 'nullable|email|max:100|unique:users,email',
            'password'   => 'required|string|min:6|max:50',
            'theme_id'   => 'required|exists:temas,id',
            'package_id' => 'required|exists:pakets,id',
        ]);

        $user = \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
            $user = User::create([
                'username'          => $validated['username'],
                'email'             => $validated['email'],
                'password'          => Hash::make($validated['password']),
                'role'              => 'client',
                'email_verified_at' => now(),
            ]);

            $paket = Paket::find($validated['package_id']);
            $activeDays = $paket ? $paket->active_days : 90;
            $expireDate = now()->addDays($activeDays);

            $user->undangans()->create([
                'slug'       => $validated['slug'],
                'tema_id'    => $validated['theme_id'],
                'paket_id'   => $validated['package_id'],
                'status'     => 'aktif',
                'expired_at' => $expireDate,
                'pria_nama'  => 'Pria',
                'wanita_nama' => 'Wanita',
            ]);

            return $user;
        });

        return response()->json([
            'message' => 'Klien berhasil dibuat.',
        ]);
    }

    public function show($id)
    {
        $client = User::where('role', 'client')
            ->with(['undangans.tema', 'undangans.paket', 'undangans.tamus', 'undangans.ucapans', 'undangans.galeris', 'undangans.ceritas', 'undangans.kados', 'undangans.acaras'])
            ->findOrFail($id);

        return response()->json([
            'client' => $client,
            'undangan' => $client->undangans()->first()
        ]);
    }

    public function update(Request $request, $id)
    {
        $client = User::where('role', 'client')->findOrFail($id);
        $undangan = $client->undangans()->first();

        $request->merge([
            'username' => Str::slug($request->username),
            'slug'     => Str::slug($request->slug ?: $request->username),
        ]);

        $validated = $request->validate([
            'username'   => [
                'required', 'string', 'max:50', 
                Rule::unique('users', 'username')->ignore($client->id),
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Username ini tidak bisa digunakan.');
                    }
                }
            ],
            'slug'       => [
                'required', 'string', 'max:100',
                Rule::unique('undangans', 'slug')->ignore($undangan?->id),
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('URL Slug ini tidak bisa digunakan.');
                    }
                }
            ],
            'email'      => ['nullable', 'email', 'max:100', Rule::unique('users', 'email')->ignore($client->id)],
            'password'   => 'nullable|string|min:6|max:50',
            'status'     => 'required|in:aktif,kedaluwarsa',
            'theme_id'   => 'required|exists:temas,id',
            'package_id' => 'nullable|exists:pakets,id',
        ]);

        $client->username = $validated['username'];
        $client->email    = $validated['email'];
        if (!empty($validated['password'])) {
            $client->password = Hash::make($validated['password']);
        }
        $client->save();

        if ($undangan) {
            $undangan->status = $validated['status'];
            $undangan->tema_id = $validated['theme_id'];
            if (array_key_exists('package_id', $validated)) {
                $undangan->paket_id = $validated['package_id'];
                $paket = Paket::find($validated['package_id']);
                if ($paket && $validated['status'] === 'aktif') {
                    $undangan->expired_at = now()->addDays($paket->active_days);
                }
            }
            $undangan->slug = $validated['slug'];
            $undangan->save();
        }

        return response()->json([
            'message' => 'Data klien berhasil diperbarui.',
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $client = User::where('role', 'client')->findOrFail($id);
        $undangan = $client->undangans()->first();

        if (!$undangan) {
            return response()->json(['message' => 'Klien belum memiliki undangan.'], 404);
        }

        $validated = $request->validate([
            'status'   => 'required|in:aktif,kedaluwarsa',
            'theme_id' => 'nullable|exists:temas,id',
        ]);

        $undangan->status = $validated['status'];

        if ($validated['status'] === 'aktif') {
            $paket = $undangan->paket;
            $activeDays = $paket ? $paket->active_days : 3;
            $undangan->expired_at = now()->addDays($activeDays);
        }

        if (!empty($validated['theme_id'])) {
            $undangan->tema_id = $validated['theme_id'];
        }

        $undangan->save();

        return response()->json(['message' => 'Status undangan berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $client = User::where('role', 'client')->findOrFail($id);

        foreach ($client->undangans as $undangan) {
            $undangan->tamus()->delete();
            $undangan->ucapans()->delete();
            $undangan->galeris()->delete();
            $undangan->ceritas()->delete();
            $undangan->kados()->delete();
            $undangan->acaras()->delete();
            $undangan->delete();
        }

        $client->delete();

        return response()->json(['message' => 'Klien berhasil dihapus.']);
    }

    public function impersonate($id)
    {
        $client = User::where('role', 'client')->findOrFail($id);

        session()->put('admin_impersonate_id', auth()->id());
        auth()->login($client);

        return redirect()->route('client.dashboard');
    }
}
