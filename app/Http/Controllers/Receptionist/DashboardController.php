<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = \App\Models\Invitation::with(['user'])
                    ->whereIn('status', ['active', 'trial'])
                    ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('pria_nama', 'like', "%{$search}%")
                  ->orWhere('wanita_nama', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $invitations = $query->paginate(12)->withQueryString();

        return view('receptionist.dashboard', compact('invitations', 'search'));
    }
}
