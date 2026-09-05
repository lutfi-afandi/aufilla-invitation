<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTema extends Model
{
    use HasFactory;

    protected $table = 'kategori_temas';

    protected $fillable = [
        'nama',
        'slug',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'is_active' => 'boolean',
    ];

    public function temas()
    {
        return $this->hasMany(Tema::class, 'kategori_tema_id');
    }
}
