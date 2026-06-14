<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
    protected $invitationService;

    public function __construct(\App\Services\InvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'couple_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username', 'unique:invitations,slug'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = $this->invitationService->quickRegister([
            'couple_name' => $request->couple_name,
            'username' => strtolower($request->username),
            'email' => $request->email,
            'password' => $request->password,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Check if username/slug is available.
     */
    public function checkUsername(Request $request)
    {
        $username = \Illuminate\Support\Str::slug($request->query('username'));
        
        if (empty($username)) {
            return response()->json(['available' => false, 'message' => 'Username tidak boleh kosong']);
        }
        
        // Reserved words
        $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
        if (in_array($username, $reserved)) {
            return response()->json(['available' => false, 'message' => 'Username ini tidak bisa digunakan']);
        }

        $excludeId = $request->query('exclude_id');

        $userQuery = \App\Models\User::where('username', $username);
        $slugQuery = \App\Models\Invitation::where('slug', $username);

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
