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

        $clients = $query->latest()->paginate(15)->withQueryString();
        $themes  = Theme::where('is_active', true)->get();

        return view('admin.clients.index', compact('clients', 'themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'nullable|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|max:50',
            'theme_id' => 'required|exists:themes,id',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'client',
        ]);

        $user->invitation()->create([
            'slug'           => Str::slug($validated['username']) . '-' . Str::random(6),
            'theme_id'       => $validated['theme_id'],
            'status'         => 'trial',
            'trial_habis_at' => now()->addDays(3),
        ]);

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
            ->with(['invitation.theme', 'invitation.tamus', 'invitation.ucapans', 'invitation.galeris', 'invitation.ceritas', 'invitation.kados', 'invitation.acaras'])
            ->findOrFail($id);

        return response()->json([
            'client' => $client,
            'invitation' => $client->invitation
        ]);
    }

    public function update(Request $request, $id)
    {
        $client = User::where('role', 'client')->findOrFail($id);

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($client->id)],
            'email'    => ['nullable', 'email', 'max:100', Rule::unique('users', 'email')->ignore($client->id)],
            'password' => 'nullable|string|min:6|max:50',
            'status'   => 'required|in:trial,active,expired',
            'theme_id' => 'required|exists:themes,id',
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
            
            if ($validated['status'] === 'active') {
                $invitation->trial_habis_at = null;
            } elseif ($validated['status'] === 'trial' && !$invitation->trial_habis_at) {
                $invitation->trial_habis_at = now()->addDays(3);
            }
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
            'status'   => 'required|in:draft,trial,aktif,nonaktif',
            'theme_id' => 'nullable|exists:themes,id',
        ]);

        $invitation->status = $validated['status'];

        if ($validated['status'] === 'aktif') {
            $invitation->trial_habis_at = null;
        } elseif ($validated['status'] === 'trial') {
            $invitation->trial_habis_at = now()->addDays(3);
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
