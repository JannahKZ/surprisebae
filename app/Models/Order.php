<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_type',
        'payment_method',      // rename from buy_method to payment_method
        'status',
        'total_amount',
        'shipping_option',     // pickup or delivery
        'pickup_name',
        'pickup_phone',
        'delivery_name',
        'delivery_phone',
        'delivery_address',
        'date',
        'time',
        'delivery_email',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

}

