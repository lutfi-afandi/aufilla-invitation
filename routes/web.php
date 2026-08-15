<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing');
Route::post('/register-client', [\App\Http\Controllers\LandingController::class, 'register'])->name('landing.register');

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

        // Clients
        Route::get('/clients', [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('clients.index');
        Route::post('/clients', [\App\Http\Controllers\Admin\ClientController::class, 'store'])->name('clients.store');
        Route::get('/clients/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'show'])->name('clients.show');
        Route::put('/clients/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('clients.destroy');
        Route::patch('/clients/{id}/status', [\App\Http\Controllers\Admin\ClientController::class, 'updateStatus'])->name('clients.status');
        Route::get('/clients/{id}/impersonate', [\App\Http\Controllers\Admin\ClientController::class, 'impersonate'])->name('clients.impersonate');

        // Themes (Temas)
        Route::get('/themes', [\App\Http\Controllers\Admin\TemaController::class, 'index'])->name('themes.index');
        Route::post('/themes', [\App\Http\Controllers\Admin\TemaController::class, 'store'])->name('themes.store');
        Route::put('/themes/{id}', [\App\Http\Controllers\Admin\TemaController::class, 'update'])->name('themes.update');
        Route::patch('/themes/{id}/toggle', [\App\Http\Controllers\Admin\TemaController::class, 'toggleActive'])->name('themes.toggle');
        Route::delete('/themes/{id}', [\App\Http\Controllers\Admin\TemaController::class, 'destroy'])->name('themes.destroy');

        // Pakets
        Route::get('/pakets', [\App\Http\Controllers\Admin\PaketController::class, 'index'])->name('pakets.index');
        Route::post('/pakets', [\App\Http\Controllers\Admin\PaketController::class, 'store'])->name('pakets.store');
        Route::put('/pakets/{id}', [\App\Http\Controllers\Admin\PaketController::class, 'update'])->name('pakets.update');
        Route::delete('/pakets/{id}', [\App\Http\Controllers\Admin\PaketController::class, 'destroy'])->name('pakets.destroy');

        // Receptionists
        Route::get('/receptionists', [\App\Http\Controllers\Admin\ReceptionistController::class, 'index'])->name('receptionists.index');
        Route::post('/receptionists', [\App\Http\Controllers\Admin\ReceptionistController::class, 'store'])->name('receptionists.store');
        Route::put('/receptionists/{id}', [\App\Http\Controllers\Admin\ReceptionistController::class, 'update'])->name('receptionists.update');
        Route::delete('/receptionists/{id}', [\App\Http\Controllers\Admin\ReceptionistController::class, 'destroy'])->name('receptionists.destroy');

        // Users
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    });

    // Client Routes
    Route::middleware(['role:client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/tutorial', [\App\Http\Controllers\Client\DashboardController::class, 'tutorial'])->name('tutorial');
        Route::get('/tamu', [\App\Http\Controllers\Client\DashboardController::class, 'tamu'])->name('tamu');
        Route::get('/tamu/data', [\App\Http\Controllers\Client\TamuController::class, 'index'])->name('tamu.data');
        Route::get('/tamu/export-excel', [\App\Http\Controllers\Client\TamuController::class, 'exportExcel'])->name('tamu.export');
        Route::get('/tamu/template-excel', [\App\Http\Controllers\Client\TamuController::class, 'downloadTemplate'])->name('tamu.template');

        Route::middleware([\App\Http\Middleware\CheckClientExpired::class])->group(function () {
            Route::get('/pengantin', [\App\Http\Controllers\Client\DashboardController::class, 'pengantin'])->name('pengantin');
            Route::get('/acara', [\App\Http\Controllers\Client\DashboardController::class, 'acara'])->name('acara');
            Route::get('/pengaturan', [\App\Http\Controllers\Client\DashboardController::class, 'pengaturan'])->name('pengaturan');
            Route::get('/galeri', [\App\Http\Controllers\Client\DashboardController::class, 'galeri'])->name('galeri');
            Route::get('/cerita', [\App\Http\Controllers\Client\DashboardController::class, 'cerita'])->name('cerita');
            Route::get('/kado', [\App\Http\Controllers\Client\DashboardController::class, 'kado'])->name('kado');

            // Form Data endpoints (AJAX Submissions)
            Route::post('/mempelai', [\App\Http\Controllers\Client\UndanganController::class, 'updateMempelai'])->name('mempelai.update');
            Route::post('/acara', [\App\Http\Controllers\Client\UndanganController::class, 'updateAcara'])->name('acara.update');
            Route::post('/pengaturan', [\App\Http\Controllers\Client\UndanganController::class, 'updateSettings'])->name('pengaturan.update');

            // Feature endpoints
            Route::post('/galeri', [\App\Http\Controllers\Client\FeatureController::class, 'storeGaleri'])->name('galeri.store');
            Route::delete('/galeri/{id}', [\App\Http\Controllers\Client\FeatureController::class, 'destroyGaleri'])->name('galeri.destroy');

            Route::post('/cerita', [\App\Http\Controllers\Client\FeatureController::class, 'storeCerita'])->name('cerita.store');
            Route::put('/cerita/{id}', [\App\Http\Controllers\Client\FeatureController::class, 'updateCerita'])->name('cerita.update');
            Route::delete('/cerita/{id}', [\App\Http\Controllers\Client\FeatureController::class, 'destroyCerita'])->name('cerita.destroy');

            Route::post('/kado/alamat', [\App\Http\Controllers\Client\FeatureController::class, 'updateAlamatKado'])->name('kado.alamat.update');
            Route::post('/kado', [\App\Http\Controllers\Client\FeatureController::class, 'storeKado'])->name('kado.store');
            Route::delete('/kado/{id}', [\App\Http\Controllers\Client\FeatureController::class, 'destroyKado'])->name('kado.destroy');

            // Tamu Management endpoints
            Route::post('/tamu', [\App\Http\Controllers\Client\TamuController::class, 'store'])->name('tamu.store');
            Route::delete('/tamu/{id}', [\App\Http\Controllers\Client\TamuController::class, 'destroy'])->name('tamu.destroy');
            Route::post('/tamu/{id}/toggle-wa', [\App\Http\Controllers\Client\TamuController::class, 'toggleWa'])->name('tamu.toggleWa');
            Route::post('/tamu/import-excel', [\App\Http\Controllers\Client\TamuController::class, 'importExcel'])->name('tamu.import');
        });
    });

    // Receptionist Routes
    Route::middleware(['role:resepsionis'])->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Receptionist\DashboardController::class, 'index'])->name('dashboard');

        // Buku Tamu (Scanner & Manual Check-in)
        Route::get('/buku-tamu/template-excel', [\App\Http\Controllers\Receptionist\BukuTamuController::class, 'downloadTemplate'])->name('buku-tamu.template-excel');
        Route::get('/buku-tamu/{id}', [\App\Http\Controllers\Receptionist\BukuTamuController::class, 'index'])->name('buku-tamu');
        Route::get('/buku-tamu/{id}/search', [\App\Http\Controllers\Receptionist\BukuTamuController::class, 'search'])->name('buku-tamu.search');
        Route::post('/buku-tamu/{id}/check-in', [\App\Http\Controllers\Receptionist\BukuTamuController::class, 'checkIn'])->name('buku-tamu.check-in');
        Route::post('/buku-tamu/{id}/add-guest', [\App\Http\Controllers\Receptionist\BukuTamuController::class, 'addGuest'])->name('buku-tamu.add-guest');
        Route::post('/buku-tamu/{id}/upload-bg', [\App\Http\Controllers\Receptionist\BukuTamuController::class, 'uploadBg'])->name('buku-tamu.upload-bg');
        Route::post('/buku-tamu/{id}/import-excel', [\App\Http\Controllers\Receptionist\BukuTamuController::class, 'importExcel'])->name('buku-tamu.import-excel');

        // Welcome Screen (Dual Screen Display)
        Route::get('/welcome-screen/{id}', [\App\Http\Controllers\Receptionist\BukuTamuController::class, 'welcomeScreen'])->name('welcome-screen');
    });

    // Stop Impersonation (admin returning from client session)
    Route::get('/admin/impersonate/stop', function () {
        $adminId = session()->pull('admin_impersonate_id');
        if ($adminId) {
            auth()->loginUsingId($adminId);
        }
        return redirect()->route('admin.dashboard');
    })->name('admin.impersonate.stop');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth & System check routes
Route::get('/api/check-username', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'checkUsername'])->name('api.check-username');

require __DIR__.'/auth.php';

// ==========================================
// OPEN GRAPH IMAGE GENERATOR
// ==========================================
Route::get('/og-image/{id}.jpg', [\App\Http\Controllers\Client\OgImageController::class, 'generate'])->name('og-image');

// ==========================================
// PUBLIC INVITATION ROUTE (Must be at the very bottom, after all other routes including auth) ---
Route::get('/preview/theme/{theme_code}', [\App\Http\Controllers\PublicInvitationController::class, 'preview'])->name('theme.preview');
Route::post('/{slug}/ucapan', [\App\Http\Controllers\PublicInvitationController::class, 'storeUcapan'])->name('public.ucapan.store');
Route::get('/{slug}', [\App\Http\Controllers\PublicInvitationController::class, 'show'])->name('public.invitation');
