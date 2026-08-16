<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    protected $fillable = [
        'undangan_id',
        'nama_tamu',
        'slug',
        'no_whatsapp',
        'kode_qr',
        'is_wa_sent',
        'waktu_hadir',
    ];

    protected $casts = [
        'is_wa_sent' => 'boolean',
        'waktu_hadir' => 'datetime',
    ];

    protected $appends = [
        'no_wa',
    ];

    public function getNoWaAttribute()
    {
        return $this->no_whatsapp;
    }

    public function undangan()
    {
        return $this->belongsTo(Undangan::class);
    }

    public function getUrlKehadiranAttribute()
    {
        return route('public.invitation', ['slug' => $this->undangan->slug, 'to' => $this->nama_tamu]);
    }
}
