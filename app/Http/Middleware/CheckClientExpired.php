<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckClientExpired
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->role === 'client') {
            $undangan = $user->undangans()->first();
            
            $isExpired = false;
            if ($undangan) {
                if ($undangan->status === 'kedaluwarsa' || $undangan->isExpired()) {
                    $isExpired = true;
                }
            }

            if ($isExpired) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json(['error' => 'Paket Anda telah kedaluwarsa (Expired). Anda tidak dapat melakukan aksi ini.'], 403);
                }
                
                return redirect()->route('client.dashboard')
                    ->with('error', 'Paket Anda telah kedaluwarsa. Silakan upgrade paket untuk mengaktifkan kembali fitur ini.');
            }
        }

        return $next($request);
    }
}
