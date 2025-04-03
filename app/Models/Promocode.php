<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'used_count',
        'is_active',
        'valid_from',
        'valid_until',
        'max_uses',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'value' => 'decimal:2',
    ];
} 