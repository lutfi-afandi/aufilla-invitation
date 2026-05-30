<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ucapan extends Model
{
    protected $fillable = [
        'invitation_id', 'nama', 'kehadiran', 'pesan', 'is_hidden'
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
