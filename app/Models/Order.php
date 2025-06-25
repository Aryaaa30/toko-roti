<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_code', 'status', 'payment_status', 'invoice_id', 'total_price'];

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($order) {
            $order->items()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
