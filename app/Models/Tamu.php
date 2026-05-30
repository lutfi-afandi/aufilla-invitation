<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $fillable = [
        'invitation_id',
        'nama_tamu',
        'no_wa',
        'is_wa_sent',
        'kode_qr',
    ];

    protected $casts = [
        'is_wa_sent' => 'boolean',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_qr)) {
                $model->kode_qr = \Illuminate\Support\Str::random(10);
            }
        });
    }
}
