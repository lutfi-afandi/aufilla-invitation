<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Undangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tema_id',
        'paket_id',
        'slug',
        'status',
        'expired_at',
        'pria_nama',
        'pria_nama_lengkap',
        'pria_ayah',
        'pria_ibu',
        'pria_foto',
        'wanita_nama',
        'wanita_nama_lengkap',
        'wanita_ayah',
        'wanita_ibu',
        'wanita_foto',
        'kutipan_sumber',
        'kutipan_teks',
        'cover_img',
        'music_file',
        'is_galeri_aktif',
        'is_cerita_aktif',
        'is_kado_aktif',
        'alamat_kado',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'is_galeri_aktif' => 'boolean',
        'is_cerita_aktif' => 'boolean',
        'is_kado_aktif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
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

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function getMusicUrlAttribute()
    {
        if (!$this->music_file) {
            return asset('assets/default/default-music.mp3');
        }
        return asset('storage/' . $this->music_file);
    }

    public function isExpired()
    {
        return $this->expired_at && $this->expired_at->isPast();
    }

    public function getFeatureAccess(): array
    {
        return [
            'can_galeri' => true,
            'can_cerita' => $this->paket ? (bool)$this->paket->has_love_story : false,
            'can_music' => $this->paket ? (bool)$this->paket->can_custom_music : false,
            'can_kado' => true,
        ];
    }
}
