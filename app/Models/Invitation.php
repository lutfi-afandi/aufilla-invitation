<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'user_id', 'theme_id', 'package_id', 'slug', 'status', 'trial_habis_at',
        'pria_nama', 'pria_nama_lengkap', 'pria_ayah', 'pria_ibu',
        'wanita_nama', 'wanita_nama_lengkap', 'wanita_ayah', 'wanita_ibu',
        'kutipan_sumber', 'kutipan_teks',
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
        if ($this->music_file && \App\Helpers\PackageHelper::canAccessCustomMusic($this)) {
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
        return [
            'can_cerita' => \App\Helpers\PackageHelper::canAccessLoveStory($this),
            'can_music'  => \App\Helpers\PackageHelper::canAccessCustomMusic($this),
            'max_galeri' => \App\Helpers\PackageHelper::getMaxGalleryPhotos($this),
        ];
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
     * Mengecek apakah data acara utama (akad & resepsi) sudah lengkap.
     */
    public function isDataAcaraComplete(): bool
    {
        $akad = $this->acaras()->where('tipe_acara', 'akad')->first();
        $resepsi = $this->acaras()->where('tipe_acara', 'resepsi')->first();

        return $akad && $resepsi &&
               !empty($akad->tgl_acara) && !empty($akad->waktu_mulai) && !empty($akad->lokasi) &&
               !empty($resepsi->tgl_acara) && !empty($resepsi->waktu_mulai) && !empty($resepsi->lokasi);
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
