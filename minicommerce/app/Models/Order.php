<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi mass-assignment
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

    // Casting tipe data otomatis
    protected $casts = [
        'paid_at'        => 'datetime',
        'total_amount'   => 'decimal:0',
        'shipping_cost'  => 'decimal:0',
        'service_fee'    => 'decimal:0',
    ];

    /** ===== RELATIONS ===== **/

    // Relasi ke user (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke item pesanan
    public function items()
    {
        return $this->hasMany(Order_item::class);
<<<<<<< HEAD
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
=======
>>>>>>> 9857363 (integrasi dasbor & autentikasi)
    }
}
