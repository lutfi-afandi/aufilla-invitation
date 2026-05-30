<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dynamic Dashboard redirect based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'resepsionis') {
            return redirect()->route('receptionist.dashboard');
        }
        return redirect()->route('client.dashboard');
    })->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    });

    // Client Routes
    Route::middleware(['role:client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengantin', [\App\Http\Controllers\Client\DashboardController::class, 'pengantin'])->name('pengantin');
        Route::get('/acara', [\App\Http\Controllers\Client\DashboardController::class, 'acara'])->name('acara');
        Route::get('/tamu', [\App\Http\Controllers\Client\DashboardController::class, 'tamu'])->name('tamu');
        Route::get('/pengaturan', [\App\Http\Controllers\Client\DashboardController::class, 'pengaturan'])->name('pengaturan');

        // Form Data endpoints (AJAX Submissions)
        Route::post('/mempelai', [\App\Http\Controllers\Client\InvitationController::class, 'updateMempelai'])->name('mempelai.update');
        Route::post('/acara', [\App\Http\Controllers\Client\InvitationController::class, 'updateAcara'])->name('acara.update');
        Route::post('/pengaturan', [\App\Http\Controllers\Client\InvitationController::class, 'updateSettings'])->name('pengaturan.update');

        // Tamu Management endpoints
        Route::get('/tamu/data', [\App\Http\Controllers\Client\TamuController::class, 'index'])->name('tamu.data');
        Route::post('/tamu', [\App\Http\Controllers\Client\TamuController::class, 'store'])->name('tamu.store');
        Route::delete('/tamu/{id}', [\App\Http\Controllers\Client\TamuController::class, 'destroy'])->name('tamu.destroy');
    });

    // --- PUBLIC INVITATION ROUTE (Must be at the bottom) ---
    Route::post('/{slug}/ucapan', [\App\Http\Controllers\PublicInvitationController::class, 'storeUcapan'])->name('public.ucapan.store');
    Route::get('/{slug}', [\App\Http\Controllers\PublicInvitationController::class, 'show'])->name('public.invitation');

    // Receptionist Routes
    Route::middleware(['role:resepsionis'])->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Receptionist\DashboardController::class, 'index'])->name('dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
