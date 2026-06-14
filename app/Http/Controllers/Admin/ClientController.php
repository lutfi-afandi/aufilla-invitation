<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'client')
            ->with('invitation.theme');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $clients  = $query->latest()->paginate(15)->withQueryString();
        $themes   = Theme::where('is_active', true)->get();
        $packages = \App\Models\Package::all();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.clients.partials.table-content', compact('clients'))->render()
            ]);
        }

        return view('admin.clients.index', compact('clients', 'themes', 'packages'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'username' => Str::slug($request->username)
        ]);

        $validated = $request->validate([
            'username'   => [
                'required', 'string', 'max:50', 'unique:users,username', 'unique:invitations,slug',
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Username ini tidak bisa digunakan.');
                    }
                }
            ],
            'email'      => 'nullable|email|max:100|unique:users,email',
            'password'   => 'required|string|min:6|max:50',
            'theme_id'   => 'required|exists:themes,id',
            'package_id' => 'required|exists:packages,id',
        ], [
            'username.required' => 'Username / Link Undangan wajib diisi.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username / Link Undangan sudah dipakai orang lain.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.max' => 'Password maksimal 50 karakter.',
            'theme_id.required' => 'Anda harus memilih Tema Undangan.',
            'theme_id.exists' => 'Tema yang dipilih tidak valid atau tidak ditemukan.',
            'package_id.required' => 'Anda harus memilih Paket Undangan.',
            'package_id.exists' => 'Paket yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $user = \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
            $user = User::create([
                'username' => $validated['username'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'client',
            ]);

            $package = \App\Models\Package::find($validated['package_id']);
            $activeDays = $package ? $package->active_days : 90;
            $expireDate = now()->addDays($activeDays);
            if ($expireDate->year > 2037) {
                $expireDate = \Carbon\Carbon::create(2037, 12, 31, 23, 59, 59);
            }

            $user->invitation()->create([
                'slug'           => $validated['username'],
                'theme_id'       => $validated['theme_id'],
                'package_id'     => $validated['package_id'],
                'status'         => 'active',
                'trial_habis_at' => $expireDate,
                'pria_nama'      => 'Pria',
                'wanita_nama'    => 'Wanita',
            ]);

            return $user;
        });

        $user->load('invitation.theme');
        $html = view('admin.clients.partials.row', ['client' => $user])->render();

        return response()->json([
            'message' => 'Klien berhasil dibuat.',
            'html' => $html
        ]);
    }

    public function show($id)
    {
        $client = User::where('role', 'client')
            ->with(['invitation.theme', 'invitation.package', 'invitation.tamus', 'invitation.ucapans', 'invitation.galeris', 'invitation.ceritas', 'invitation.kados', 'invitation.acaras'])
            ->findOrFail($id);

        return response()->json([
            'client' => $client,
            'invitation' => $client->invitation
        ]);
    }

    public function update(Request $request, $id)
    {
        $client = User::where('role', 'client')->findOrFail($id);

        $request->merge([
            'username' => Str::slug($request->username)
        ]);

        $validated = $request->validate([
            'username'   => [
                'required', 'string', 'max:50', 
                Rule::unique('users', 'username')->ignore($client->id),
                Rule::unique('invitations', 'slug')->ignore($client->invitation?->id),
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Username ini tidak bisa digunakan.');
                    }
                }
            ],
            'email'      => ['nullable', 'email', 'max:100', Rule::unique('users', 'email')->ignore($client->id)],
            'password'   => 'nullable|string|min:6|max:50',
            'status'     => 'required|in:trial,active,expired',
            'theme_id'   => 'required|exists:themes,id',
            'package_id' => 'nullable|exists:packages,id',
        ], [
            'username.required' => 'Username / Link Undangan wajib diisi.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username / Link Undangan sudah dipakai orang lain.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.max' => 'Password maksimal 50 karakter.',
            'status.required' => 'Status klien wajib dipilih.',
            'status.in' => 'Pilihan status tidak valid.',
            'theme_id.required' => 'Anda harus memilih Tema Undangan.',
            'theme_id.exists' => 'Tema yang dipilih tidak valid atau tidak ditemukan.',
            'package_id.exists' => 'Paket yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        $client->username = $validated['username'];
        $client->email    = $validated['email'];
        if (!empty($validated['password'])) {
            $client->password = Hash::make($validated['password']);
        }
        $client->save();

        if ($invitation = $client->invitation) {
            $invitation->status = $validated['status'];
            $invitation->theme_id = $validated['theme_id'];
            if (array_key_exists('package_id', $validated)) {
                $invitation->package_id = $validated['package_id'];
            }
                
            if ($validated['status'] === 'active') {
                $package = \App\Models\Package::find($invitation->package_id);
                $activeDays = $package ? $package->active_days : 90;
                $expireDate = now()->addDays($activeDays);
                if ($expireDate->year > 2037) {
                    $expireDate = \Carbon\Carbon::create(2037, 12, 31, 23, 59, 59);
                }
                // Only update the expiration date if it was trial, or recalculate from now if it was already active
                $invitation->trial_habis_at = $expireDate;
            } elseif ($validated['status'] === 'trial' && !$invitation->trial_habis_at) {
                $invitation->trial_habis_at = $invitation->created_at->copy()->addDay();
            }
            
            $invitation->slug = $validated['username'];
            $invitation->save();
        }

        $client->load('invitation.theme');
        $html = view('admin.clients.partials.row', ['client' => $client])->render();

        return response()->json([
            'message' => 'Data klien berhasil diperbarui.',
            'html' => $html
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $client = User::where('role', 'client')->findOrFail($id);
        $invitation = $client->invitation;

        if (!$invitation) {
            return response()->json(['message' => 'Klien belum memiliki undangan.'], 404);
        }

        $validated = $request->validate([
            'status'   => 'required|in:trial,active,expired',
            'theme_id' => 'nullable|exists:themes,id',
        ]);

        $invitation->status = $validated['status'];

        if ($validated['status'] === 'active') {
            $package = \App\Models\Package::find($invitation->package_id);
            $activeDays = $package ? $package->active_days : 90;
            $expireDate = now()->addDays($activeDays);
            if ($expireDate->year > 2037) {
                $expireDate = \Carbon\Carbon::create(2037, 12, 31, 23, 59, 59);
            }
            $invitation->trial_habis_at = $expireDate;
        } elseif ($validated['status'] === 'trial' && !$invitation->trial_habis_at) {
            $invitation->trial_habis_at = $invitation->created_at->copy()->addDay();
        }

        if (!empty($validated['theme_id'])) {
            $invitation->theme_id = $validated['theme_id'];
        }

        $invitation->save();

        return response()->json(['message' => 'Status undangan berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $client = User::where('role', 'client')->findOrFail($id);

        // Cascade delete invitation and related data
        if ($invitation = $client->invitation) {
            $invitation->tamus()->delete();
            $invitation->ucapans()->delete();
            $invitation->galeris()->delete();
            $invitation->ceritas()->delete();
            $invitation->kados()->delete();
            $invitation->acaras()->delete();
            $invitation->delete();
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
