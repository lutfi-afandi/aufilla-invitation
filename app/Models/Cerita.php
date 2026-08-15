<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cerita extends Model
{
    use HasFactory;

    protected $fillable = [
        'undangan_id',
        'judul',
        'tanggal',
        'isi',
    ];

    public function undangan()
    {
        return $this->belongsTo(Undangan::class);
    }
}
