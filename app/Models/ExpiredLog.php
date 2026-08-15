<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiredLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'executed_at',
        'total_expired',
        'affected_invitations',
        'status',
        'notes',
    ];

    protected $casts = [
        'executed_at' => 'datetime',
        'affected_invitations' => 'array',
    ];
}
