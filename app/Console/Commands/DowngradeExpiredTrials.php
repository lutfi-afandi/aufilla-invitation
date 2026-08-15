<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Undangan;

class DowngradeExpiredTrials extends Command
{
    protected $signature = 'invitation:check-expired';
    protected $description = 'Periksa dan ubah status undangan yang masa aktifnya telah habis menjadi kedaluwarsa';

    public function handle()
    {
        $this->info('Mengecek undangan kedaluwarsa...');

        $expiredInvitations = Undangan::where('status', 'aktif')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->get();

        if ($expiredInvitations->isEmpty()) {
            $this->info('Tidak ada undangan yang kedaluwarsa saat ini.');
            return;
        }

        $count = 0;
        foreach ($expiredInvitations as $invitation) {
            $invitation->update([
                'status' => 'kedaluwarsa',
            ]);
            $count++;
            $this->line("Undangan ID {$invitation->id} ({$invitation->slug}) telah diubah ke status kedaluwarsa.");
        }

        $this->info("Selesai. Berhasil memperbarui {$count} undangan.");
    }
}
