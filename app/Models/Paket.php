<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'active_days',
        'max_gallery_photos',
        'has_love_story',
        'can_custom_music',
        'is_priority_support',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active_days' => 'integer',
        'max_gallery_photos' => 'integer',
        'has_love_story' => 'boolean',
        'can_custom_music' => 'boolean',
        'is_priority_support' => 'boolean',
    ];

    public function undangans()
    {
        return $this->hasMany(Undangan::class);
    }
}
