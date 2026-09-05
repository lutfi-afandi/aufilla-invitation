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
        'kategori_tema_id',
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

    public function kategoriTema()
    {
        return $this->belongsTo(KategoriTema::class, 'kategori_tema_id');
    }

    public function undangans()
    {
        return $this->hasMany(Undangan::class);
    }
}
