<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;

    protected $fillable = [
        'undangan_id',
        'nama_acara',
        'tipe_acara',
        'tgl_acara',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'alamat',
        'gmaps_link',
    ];

    public function undangan()
    {
        return $this->belongsTo(Undangan::class);
    }
}
