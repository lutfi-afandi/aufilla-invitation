<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Undangan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Undangan::with(['user'])
                    ->where('status', 'aktif')
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
