<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 'price', 'active_days', 'max_gallery_photos',
        'has_love_story', 'can_custom_music', 'is_priority_support', 'description'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'has_love_story' => 'boolean',
        'can_custom_music' => 'boolean',
        'is_priority_support' => 'boolean',
    ];

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
