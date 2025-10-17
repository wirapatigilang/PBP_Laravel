<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // kolom yang boleh di-mass assign
    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_method',
        'payment_status',
        'paid_at',
        'shipping_method',
        'shipping_cost',
        'service_fee',
    ];

    // casting tipe data
    protected $casts = [
        'paid_at' => 'datetime',
        'total_amount'  => 'decimal:0',
        'shipping_cost' => 'decimal:0',
        'service_fee'   => 'decimal:0',
    ];

    /** RELATIONS **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
