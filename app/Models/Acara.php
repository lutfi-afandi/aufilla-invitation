<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    protected $fillable = [
        'invitation_id', 'tipe_acara', 'nama_acara', 'tgl_acara', 'waktu_mulai', 
        'waktu_selesai', 'lokasi', 'alamat', 'gmaps_link'
    ];

    protected $casts = [
        'tgl_acara' => 'date',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
