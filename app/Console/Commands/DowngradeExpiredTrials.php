<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Undangan;
use App\Models\ExpiredLog;

class DowngradeExpiredTrials extends Command
{
    protected $signature = 'invitation:check-expired';
    protected $description = 'Periksa dan ubah status undangan yang masa aktifnya telah habis menjadi kedaluwarsa';

    public function handle()
    {
        $this->info('Mengecek undangan kedaluwarsa...');

        $now = now();
        $expiredInvitations = Undangan::with(['user', 'paket'])
            ->where('status', 'aktif')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', $now)
            ->get();

        $affected = [];
        $count = 0;

        foreach ($expiredInvitations as $invitation) {
            $invitation->update([
                'status' => 'kedaluwarsa',
            ]);
            $count++;
            $affected[] = [
                'id' => $invitation->id,
                'slug' => $invitation->slug,
                'username' => $invitation->user->username ?? '-',
                'paket' => $invitation->paket->name ?? '-',
                'expired_at' => $invitation->expired_at ? $invitation->expired_at->format('Y-m-d H:i:s') : null,
            ];
            $this->line("Undangan ID {$invitation->id} ({$invitation->slug}) telah diubah ke status kedaluwarsa.");
        }

        ExpiredLog::create([
            'executed_at' => $now,
            'total_expired' => $count,
            'affected_invitations' => $affected,
            'status' => 'success',
            'notes' => $count > 0 ? "Berhasil me-nonaktifkan {$count} undangan kedaluwarsa." : "Cronjob berjalan normal. Tidak ada undangan kedaluwarsa.",
        ]);

        $this->info("Selesai. Berhasil memperbarui {$count} undangan dan mencatat log eksekusi.");
    }
}
