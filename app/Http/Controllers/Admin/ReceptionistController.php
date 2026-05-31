<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ReceptionistController extends Controller
{
    public function index()
    {
        $receptionists = User::where('role', 'resepsionis')
            ->latest()
            ->get();

        $invitations = Invitation::with('user')->where('status', 'aktif')->get();

        return view('admin.receptionists.index', compact('receptionists', 'invitations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|max:50',
        ]);

        User::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'resepsionis',
        ]);

        return response()->json(['message' => 'Resepsionis berhasil dibuat.']);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'resepsionis')->findOrFail($id);

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->id)],
            'email'    => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:6|max:50',
        ]);

        $user->username = $validated['username'];
        $user->email    = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return response()->json(['message' => 'Resepsionis berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $user = User::where('role', 'resepsionis')->findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Resepsionis berhasil dihapus.']);
    }
}
