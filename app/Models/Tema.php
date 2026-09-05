<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'thumbnail',
        'category',
        'tingkatan',
        'harga_tambahan',
        'is_privat',
        'is_active',
    ];

    protected $casts = [
        'harga_tambahan' => 'decimal:2',
        'is_privat' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function undangans()
    {
        return $this->hasMany(Undangan::class);
    }
}
