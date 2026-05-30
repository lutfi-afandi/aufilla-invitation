<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'user_id', 'theme_id', 'slug', 'status', 'trial_habis_at',
        'pria_nama', 'pria_nama_lengkap', 'pria_ayah', 'pria_ibu',
        'wanita_nama', 'wanita_nama_lengkap', 'wanita_ayah', 'wanita_ibu',
        'cover_img', 'music_file', 'is_galeri_aktif', 'is_cerita_aktif', 'is_kado_aktif', 'alamat_kado',
        'pria_foto', 'wanita_foto'
    ];

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
        return $this->hasMany(Cerita::class)->orderBy('tanggal', 'asc');
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
}
