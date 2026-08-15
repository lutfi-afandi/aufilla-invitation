<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Undangan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function checkUsername(Request $request)
    {
        $username = \Illuminate\Support\Str::slug($request->query('username'));
        
        if (empty($username)) {
            return response()->json(['available' => false, 'message' => 'Username tidak boleh kosong']);
        }
        
        $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
        if (in_array($username, $reserved)) {
            return response()->json(['available' => false, 'message' => 'Username ini tidak bisa digunakan']);
        }

        $excludeId = $request->query('exclude_id');

        $userQuery = User::where('username', $username);
        $slugQuery = Undangan::where('slug', $username);

        if ($excludeId) {
            $userQuery->where('id', '!=', $excludeId);
            $slugQuery->where('user_id', '!=', $excludeId);
        }

        if ($userQuery->exists() || $slugQuery->exists()) {
            return response()->json(['available' => false, 'message' => 'URL ini sudah dipakai orang lain']);
        }

        return response()->json(['available' => true, 'slug' => $username, 'message' => 'URL tersedia!']);
    }
}
