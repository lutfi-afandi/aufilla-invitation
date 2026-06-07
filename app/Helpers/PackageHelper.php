<?php

namespace App\Helpers;

use App\Models\Invitation;

class PackageHelper
{
    /**
     * Mengecek dan men-downgrade paket ke Basic jika masa trial habis (Lazy Update).
     * Memastikan sistem bekerja otomatis walaupun cron job tidak berjalan.
     */
    public static function checkAndDowngradeExpiredTrial(Invitation $invitation): void
    {
        if ($invitation->status === 'trial' && $invitation->trial_habis_at && $invitation->trial_habis_at->isPast()) {
            $basicPackage = \App\Models\Package::where('name', 'Basic')->first();
            if ($basicPackage && $invitation->package_id !== $basicPackage->id) {
                $invitation->update(['package_id' => $basicPackage->id]);
                $invitation->load('package'); // Refresh relasi paket
            }
        }
    }

    /**
     * Mendapatkan kuota maksimal foto galeri sesuai paket.
     */
    public static function getMaxGalleryPhotos(Invitation $invitation): int
    {
        self::checkAndDowngradeExpiredTrial($invitation);

        // Pembatasan ketat untuk Trial agar tidak disalahgunakan
        if (self::isTrial($invitation)) {
            return 3;
        }

        if (!$invitation->package) {
            return 5; // Default fallback Basic
        }

        return $invitation->package->max_gallery_photos;
    }

    /**
     * Mengecek apakah klien masih bisa menambah foto galeri (kuota belum penuh).
     */
    public static function canAddGalleryPhoto(Invitation $invitation): bool
    {
        $currentCount = $invitation->galeris()->count();
        $maxPhotos = self::getMaxGalleryPhotos($invitation);

        return $currentCount < $maxPhotos;
    }

    /**
     * Mengecek apakah fitur Cerita Cinta dapat diakses (didukung oleh paket).
     */
    public static function canAccessLoveStory(Invitation $invitation): bool
    {
        self::checkAndDowngradeExpiredTrial($invitation);

        if (!$invitation->package) {
            return false;
        }

        return (bool) $invitation->package->has_love_story;
    }

    /**
     * Mengecek apakah fitur Musik Kustom dapat digunakan.
     * Klien dengan status 'trial' dilarang mengubah musik, walaupun paketnya VIP.
     */
    public static function canAccessCustomMusic(Invitation $invitation): bool
    {
        self::checkAndDowngradeExpiredTrial($invitation);

        if (!$invitation->package | $invitation->status == 'trial') {
            return false;
        }

        return (bool) $invitation->package->can_custom_music;
    }

    /**
     * Helper untuk mengecek apakah undangan masih dalam masa trial.
     */
    public static function isTrial(Invitation $invitation): bool
    {
        return $invitation->status === 'trial';
    }

    /**
     * Mendapatkan kuota maksimal tamu sesuai paket/trial.
     */
    public static function getMaxGuests(Invitation $invitation): int
    {
        self::checkAndDowngradeExpiredTrial($invitation);

        // Pembatasan ketat untuk Trial
        if (self::isTrial($invitation)) {
            return 5;
        }

        // Jika ke depan ada limit tamu di tabel package, bisa diambil dari sana
        // Sementara kita asumsikan untuk paket berbayar (Active/Expired) tamunya unlimited (9999) atau sesuai kebutuhan
        return 9999;
    }

    /**
     * Mengecek apakah klien masih bisa menambah tamu.
     */
    public static function canAddGuest(Invitation $invitation): bool
    {
        $currentCount = $invitation->tamus()->count();
        $maxGuests = self::getMaxGuests($invitation);

        return $currentCount < $maxGuests;
    }
}
