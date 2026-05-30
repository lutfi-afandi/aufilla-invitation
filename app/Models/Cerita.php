<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cerita extends Model
{
    protected $fillable = [
        'invitation_id',
        'tanggal',
        'judul',
        'isi_cerita',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
