<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $fillable = [
        'invitation_id', 'image_path'
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
