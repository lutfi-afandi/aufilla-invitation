<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Lean Controller: Hanya mengambil data via service atau eloquent ringan dan memanggil view
        // $stats = $this->adminService->getDashboardStats();
        
        return view('admin.dashboard', [
            // 'stats' => $stats
        ]);
    }
}
