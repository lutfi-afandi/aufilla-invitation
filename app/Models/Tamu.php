<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $fillable = [
        'invitation_id', 'nama_tamu', 'no_wa'
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
