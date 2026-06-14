<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Theme;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$output = [];

function record($name, $status, $message = '') {
    global $output;
    $output[] = compact('name', 'status', 'message');
}

DB::beginTransaction();

try {
    // 1. Setup Data
    $theme = Theme::firstOrCreate(['code' => 'TEST-01', 'name' => 'Test Theme', 'is_active' => true], ['path' => 'test-theme', 'price' => 0]);
    $packageTrial = Package::firstOrCreate(['name' => 'Trial', 'active_days' => 1], ['price' => 0, 'features' => '[]']);
    $packageBasic = Package::firstOrCreate(['name' => 'Basic', 'active_days' => 90], ['price' => 100, 'features' => '[]']);
    $packageVIP = Package::firstOrCreate(['name' => 'VIP', 'active_days' => 36500], ['price' => 1000, 'features' => '[]']);
    record('Setup Database Master', true, 'Tema dan Paket berhasil dimuat.');

    // 2. Test Client Registration via Service (Landing Page Simulation)
    $service = app(\App\Services\InvitationService::class);
    $user1 = current($service->quickRegister([
        'couple_name' => 'Test Couple',
        'username' => 'test-landing',
        'email' => 'testlanding@mail.com',
        'password' => 'password',
    ]));
    
    $user1 = User::where('username', 'test-landing')->first();

    if ($user1 && $user1->role === 'client' && $user1->invitation) {
        record('Pendaftaran Klien via Landing Page', true, 'Klien berhasil mendaftar, undangan trial terbuat otomatis.');
    } else {
        record('Pendaftaran Klien via Landing Page', false, 'Gagal membuat klien atau undangan.');
    }

    // 3. Test URL/Username Uniqueness
    $req = new \Illuminate\Http\Request();
    $req->merge(['username' => 'test-landing']);
    $checkCtrl = app(\App\Http\Controllers\Auth\RegisteredUserController::class);
    $res = $checkCtrl->checkUsername($req);
    $data = $res->getData();
    if ($data->available === false) {
        record('Validasi Username Unik (Existing)', true, 'Username bentrok berhasil dicegah (' . $data->message . ')');
    } else {
        record('Validasi Username Unik (Existing)', false, 'Username bentrok lolos validasi!');
    }

    $req->merge(['username' => 'admin']);
    $res = $checkCtrl->checkUsername($req);
    $data = $res->getData();
    if ($data->available === false) {
        record('Validasi Username Unik (Reserved)', true, 'Username terlarang (admin) berhasil dicegah.');
    } else {
        record('Validasi Username Unik (Reserved)', false, 'Username terlarang (admin) lolos validasi!');
    }

    // 4. Test Admin Creating Client with VIP
    $adminReq = new \Illuminate\Http\Request();
    $adminReq->merge([
        'username' => 'admin-vip-client',
        'email' => 'vip@admin.com',
        'password' => 'password123',
        'theme_id' => $theme->id,
        'package_id' => $packageVIP->id,
    ]);
    app()->instance('request', $adminReq);
    $adminCtrl = app(\App\Http\Controllers\Admin\ClientController::class);
    $adminCtrl->store($adminReq);

    $vipUser = User::where('username', 'admin-vip-client')->first();
    if ($vipUser && $vipUser->invitation && $vipUser->invitation->trial_habis_at->year <= 2038) {
        record('Admin Create Client VIP', true, 'Klien VIP berhasil dibuat, batas waktu dibatasi tahun 2037 dengan aman.');
    } else {
        record('Admin Create Client VIP', false, 'Gagal membuat klien VIP atau tanggal melebihi batas TIMESTAMP.');
    }

    // 5. Test Admin Editing Client Status (Update Status)
    $updateReq = new \Illuminate\Http\Request();
    $updateReq->merge([
        'status' => 'active',
    ]);
    app()->instance('request', $updateReq);
    $adminCtrl->updateStatus($updateReq, $user1->id);
    
    $user1->refresh();
    if ($user1->invitation->status === 'active') {
        record('Admin Update Status Klien', true, 'Status klien berhasil diubah menjadi aktif.');
    } else {
        record('Admin Update Status Klien', false, 'Gagal mengubah status klien.');
    }

    // 6. Test Admin Deleting Client
    $adminCtrl->destroy($vipUser->id);
    if (!User::where('username', 'admin-vip-client')->exists()) {
        record('Admin Delete Klien', true, 'Klien VIP dan data undangannya berhasil dihapus (Cascade Delete).');
    } else {
        record('Admin Delete Klien', false, 'Gagal menghapus klien.');
    }

} catch (\Exception $e) {
    record('Runtime Error', false, $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
}

DB::rollBack();

$report = "# Report Testing Aplikasi Undangan Aufilla\n";
$report .= "Tanggal: " . date('Y-m-d H:i:s') . "\n\n";
$report .= "| Fitur / Skenario | Status | Keterangan |\n";
$report .= "|------------------|--------|------------|\n";
foreach ($output as $out) {
    $icon = $out['status'] === 'PASS' ? '✅' : '❌';
    $report .= "| {$out['name']} | {$icon} {$out['status']} | {$out['message']} |\n";
}

file_put_contents(__DIR__ . '/report-testing-' . date('Y-m-d') . '.md', $report);
echo "Report generated successfully.\n";
