<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kado extends Model
{
    protected $fillable = [
        'invitation_id',
        'nama_bank',
        'no_rekening',
        'nama_pemilik',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
