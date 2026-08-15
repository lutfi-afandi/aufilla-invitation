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
        'is_active',
    ];

    public function undangans()
    {
        return $this->hasMany(Undangan::class);
    }
}
