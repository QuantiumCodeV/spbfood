<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'address_extra',
        'order_details',
        'promocode_id',
        'discount',
        'total_price',
        'final_price',
        'status',
        'ip',
        // UTM метки
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    protected $casts = [
        'order_details' => 'array',
        'total_price' => 'float',
        'final_price' => 'float',
        'discount' => 'float',
    ];

    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }
} 