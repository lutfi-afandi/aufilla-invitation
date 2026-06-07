<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DowngradeExpiredTrials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitation:downgrade-expired-trials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downgrade expired trial invitations to Basic package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting check for expired trial invitations...');

        // Cari paket Basic
        $basicPackage = \App\Models\Package::where('name', 'Basic')->first();
        if (!$basicPackage) {
            $this->error('Paket "Basic" tidak ditemukan di database. Pastikan seeder sudah dijalankan.');
            return;
        }

        // Ambil semua undangan yang statusnya trial dan trial_habis_at sudah lewat
        $expiredInvitations = \App\Models\Invitation::where('status', 'trial')
            ->whereNotNull('trial_habis_at')
            ->where('trial_habis_at', '<', now())
            ->where('package_id', '!=', $basicPackage->id) // Hindari update yang sudah Basic
            ->get();

        if ($expiredInvitations->isEmpty()) {
            $this->info('Tidak ada undangan trial kedaluwarsa yang perlu di-downgrade.');
            return;
        }

        $count = 0;
        foreach ($expiredInvitations as $invitation) {
            $invitation->update([
                'package_id' => $basicPackage->id,
                // Status dibiarkan 'trial' agar Admin tetap tahu dia trial yang expired
            ]);
            $count++;
            $this->line("Downgraded invitation ID: {$invitation->id} ({$invitation->slug}) to Basic package.");
        }

        $this->info("Proses selesai. Berhasil me-downgrade {$count} undangan.");
    }
}
