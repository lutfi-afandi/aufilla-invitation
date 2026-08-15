<?php

namespace App\Helpers;

use App\Models\Undangan;

class PackageHelper
{
    /**
     * Mendapatkan kuota maksimal foto galeri sesuai paket.
     */
    public static function getMaxGalleryPhotos(?Undangan $undangan): int
    {
        if (!$undangan || !$undangan->paket) {
            return 5;
        }

        return $undangan->paket->max_gallery_photos;
    }

    /**
     * Mengecek apakah klien masih bisa menambah foto galeri (kuota belum penuh).
     */
    public static function canAddGalleryPhoto(?Undangan $undangan): bool
    {
        if (!$undangan) {
            return false;
        }

        $currentCount = $undangan->galeris()->count();
        $maxPhotos = self::getMaxGalleryPhotos($undangan);

        return $currentCount < $maxPhotos;
    }

    /**
     * Mengecek apakah klien masih bisa menambah data tamu.
     */
    public static function canAddGuest(?Undangan $undangan): bool
    {
        if (!$undangan) {
            return false;
        }

        return !$undangan->isExpired();
    }

    /**
     * Mengecek apakah fitur Cerita Cinta dapat diakses (didukung oleh paket).
     */
    public static function canAccessLoveStory(?Undangan $undangan): bool
    {
        if (!$undangan || !$undangan->paket) {
            return false;
        }

        return (bool) $undangan->paket->has_love_story;
    }

    /**
     * Mengecek apakah fitur Musik Kustom dapat digunakan.
     */
    public static function canAccessCustomMusic(?Undangan $undangan): bool
    {
        if (!$undangan || !$undangan->paket) {
            return false;
        }

        return (bool) $undangan->paket->can_custom_music;
    }
}
