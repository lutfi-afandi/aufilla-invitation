<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;
use App\Models\Paket;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index(Request $request): View
    {
        $clients = User::where('role', 'client')
            ->with(['undangans.tema', 'undangans.paket'])
            ->latest()
            ->get();

        $themes = Tema::where('is_active', true)->get();
        $packages = Paket::all();

        return view('admin.clients.index', compact('clients', 'themes', 'packages'));
    }

    /**
     * Store a newly created client.
     */
    public function store(StoreClientRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'client',
                'email_verified_at' => now(),
            ]);

            $paket = Paket::find($validated['package_id']);
            $activeDays = min($paket ? $paket->active_days : 90, 3650);
            $expireDate = now()->addDays($activeDays);

            $user->undangans()->create([
                'slug' => $validated['slug'],
                'tema_id' => $validated['theme_id'],
                'paket_id' => $validated['package_id'],
                'status' => 'aktif',
                'expired_at' => $expireDate,
                'pria_nama' => 'Pria',
                'wanita_nama' => 'Wanita',
            ]);

            return $user;
        });

        // Load relations for partial row rendering
        $user->load(['undangans.tema', 'undangans.paket']);

        return response()->json([
            'success' => true,
            'message' => "Klien {$user->username} berhasil ditambahkan.",
            'client' => $user,
            'row_html' => view('admin.clients.partials.row', ['client' => $user])->render(),
        ]);
    }

    /**
     * Display the specified client details.
     */
    public function show(int $id): JsonResponse
    {
        $client = User::where('role', 'client')
            ->with([
                'undangans.tema',
                'undangans.paket',
                'undangans.tamus',
                'undangans.ucapans',
                'undangans.galeris',
                'undangans.ceritas',
                'undangans.kados',
                'undangans.acaras'
            ])
            ->findOrFail($id);

        $undangan = $client->undangans->first();

        // Calculate synchronized stats
        $stats = [
            'total_tamu' => $undangan ? $undangan->tamus->count() : 0,
            'total_ucapan' => $undangan ? $undangan->ucapans->count() : 0,
            'total_galeri' => $undangan ? $undangan->galeris->count() : 0,
            'total_cerita' => $undangan ? $undangan->ceritas->count() : 0,
            'total_kado' => $undangan ? $undangan->kados->count() : 0,
            'total_acara' => $undangan ? $undangan->acaras->count() : 0,
        ];

        $html = view('admin.clients.partials.detail', compact('client', 'undangan', 'stats'))->render();

        return response()->json([
            'success' => true,
            'client' => $client,
            'undangan' => $undangan,
            'stats' => $stats,
            'html' => $html,
        ]);
    }

    /**
     * Update the specified client.
     */
    public function update(UpdateClientRequest $request, int $id): JsonResponse
    {
        $client = User::where('role', 'client')->findOrFail($id);
        $undangan = $client->undangans->first();
        $validated = $request->validated();

        DB::transaction(function () use ($client, $undangan, $validated) {
            $client->username = $validated['username'];
            $client->email = $validated['email'];
            if (! empty($validated['password'])) {
                $client->password = Hash::make($validated['password']);
            }
            $client->save();

            if ($undangan) {
                $undangan->status = $validated['status'];
                $undangan->tema_id = $validated['theme_id'];
                if (array_key_exists('package_id', $validated) && ! empty($validated['package_id'])) {
                    $undangan->paket_id = $validated['package_id'];
                    $paket = Paket::find($validated['package_id']);
                    if ($paket && $validated['status'] === 'aktif') {
                        $activeDays = min($paket->active_days, 3650);
                        $undangan->expired_at = now()->addDays($activeDays);
                    }
                }
                $undangan->slug = $validated['slug'];
                if (array_key_exists('custom_css', $validated)) {
                    $undangan->custom_css = $validated['custom_css'];
                }
                $undangan->save();
            }
        });

        // Fresh load relations
        $client->load(['undangans.tema', 'undangans.paket']);

        return response()->json([
            'success' => true,
            'message' => "Data klien {$client->username} berhasil diperbarui.",
            'client' => $client,
            'row_html' => view('admin.clients.partials.row', ['client' => $client])->render(),
        ]);
    }

    /**
     * Update client invitation status.
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $client = User::where('role', 'client')->findOrFail($id);
        $undangan = $client->undangans->first();

        if (! $undangan) {
            return response()->json([
                'success' => false,
                'message' => 'Klien belum memiliki data undangan.',
            ], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:aktif,kedaluwarsa',
            'theme_id' => 'nullable|exists:temas,id',
        ], [
            'status.required' => 'Status undangan wajib dipilih.',
            'status.in' => 'Status harus berupa "aktif" atau "kedaluwarsa".',
            'theme_id.exists' => 'Tema yang dipilih tidak valid.',
        ]);

        $undangan->status = $validated['status'];

        if ($validated['status'] === 'aktif') {
            $paket = $undangan->paket;
            $activeDays = min($paket ? $paket->active_days : 90, 3650);
            $undangan->expired_at = now()->addDays($activeDays);
        }

        if (! empty($validated['theme_id'])) {
            $undangan->tema_id = $validated['theme_id'];
        }

        $undangan->save();

        $client->load(['undangans.tema', 'undangans.paket']);

        return response()->json([
            'success' => true,
            'message' => 'Status undangan berhasil diperbarui.',
            'client' => $client,
            'row_html' => view('admin.clients.partials.row', ['client' => $client])->render(),
        ]);
    }

    /**
     * Remove the specified client and related records.
     */
    public function destroy(int $id): JsonResponse
    {
        $client = User::where('role', 'client')->findOrFail($id);
        $username = $client->username;

        DB::transaction(function () use ($client) {
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
        });

        return response()->json([
            'success' => true,
            'message' => "Klien {$username} berhasil dihapus permanen.",
        ]);
    }

    /**
     * Impersonate as the client.
     */
    public function impersonate(int $id)
    {
        $client = User::where('role', 'client')->findOrFail($id);

        session()->put('admin_impersonate_id', auth()->id());
        auth()->login($client);

        return redirect()->route('client.dashboard');
    }
}
