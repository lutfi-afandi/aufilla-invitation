<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // View khusus untuk resepsionis scan QR (Untuk versi lanjutan)
        // return view('receptionist.dashboard');
        
        return response('Receptionist Dashboard - Under Construction');
    }
}
