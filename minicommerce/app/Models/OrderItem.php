<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_order',
        'name',
        'price',
        'qty',
        'subtotal',
        'store_name',
        'status',
        'address',
    ];

    protected $casts = [
        'quantity'       => 'integer',
        'price_at_order' => 'decimal:0',
        'price'          => 'decimal:0',
        'qty'            => 'integer',
        'subtotal'       => 'decimal:0',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
