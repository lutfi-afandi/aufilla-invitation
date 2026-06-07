<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'user_id', 'theme_id', 'package_id', 'slug', 'status', 'trial_habis_at',
        'pria_nama', 'pria_nama_lengkap', 'pria_ayah', 'pria_ibu',
        'wanita_nama', 'wanita_nama_lengkap', 'wanita_ayah', 'wanita_ibu',
        'cover_img', 'music_file', 'is_galeri_aktif', 'is_cerita_aktif', 'is_kado_aktif', 'alamat_kado',
        'pria_foto', 'wanita_foto'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    protected $casts = [
        'trial_habis_at' => 'datetime',
        'is_galeri_aktif' => 'boolean',
        'is_cerita_aktif' => 'boolean',
        'is_kado_aktif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function acaras()
    {
        return $this->hasMany(Acara::class);
    }

    public function galeris()
    {
        return $this->hasMany(Galeri::class);
    }

    public function ceritas()
    {
        return $this->hasMany(Cerita::class);
    }

    public function getMusicUrlAttribute()
    {
        if ($this->music_file) {
            return asset('storage/' . $this->music_file);
        }
        return asset('assets/default/default-music.mp3');
    }

    public function kados()
    {
        return $this->hasMany(Kado::class);
    }

    public function tamus()
    {
        return $this->hasMany(Tamu::class);
    }

    public function ucapans()
    {
        return $this->hasMany(Ucapan::class);
    }

    /**
     * Get feature access based on status and package.
     */
    public function getFeatureAccess(): array
    {
        // Default (Basic / expired)
        $access = [
            'can_cerita' => false,
            'can_music' => false,
            'max_galeri' => 5, // Basic default
        ];

        // Jika status trial, berikan semua akses (layaknya VIP) hanya jika belum kedaluwarsa
        if ($this->status === 'trial') {
            if ($this->trial_habis_at && $this->trial_habis_at->isPast()) {
                return $access; // Kedaluwarsa -> kembali ke default (Basic/terkunci)
            }
            
            $access['can_cerita'] = true;
            $access['can_music'] = true;
            $access['max_galeri'] = 999;
            return $access;
        }

        // Jika status aktif atau nonaktif tapi kita butuh ngecek paket (UI view), baca dari package
        if ($this->package) {
            $access['can_cerita'] = $this->package->has_love_story;
            $access['can_music'] = $this->package->can_custom_music;
            $access['max_galeri'] = $this->package->max_gallery_photos;
        }

        return $access;
    }

    /**
     * Mengecek apakah data pengantin sudah lengkap (nama, ortu, foto).
     */
    public function isDataPengantinComplete(): bool
    {
        return !empty($this->pria_nama) && $this->pria_nama !== 'Pria' &&
               !empty($this->pria_nama_lengkap) &&
               !empty($this->pria_ayah) &&
               !empty($this->pria_ibu) &&
               !empty($this->pria_foto) &&
               !empty($this->wanita_nama) && $this->wanita_nama !== 'Wanita' &&
               !empty($this->wanita_nama_lengkap) &&
               !empty($this->wanita_ayah) &&
               !empty($this->wanita_ibu) &&
               !empty($this->wanita_foto);
    }

    /**
     * Mengecek apakah undangan sudah kedaluwarsa.
     */
    public function isExpired(): bool
    {
        if ($this->status === 'expired' || $this->status === 'nonaktif') {
            return true;
        }
        if ($this->status === 'trial' && $this->trial_habis_at && $this->trial_habis_at->isPast()) {
            return true;
        }
        return false;
    }
}
