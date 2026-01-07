<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total_quantity',
        'subtotal',
        'delivery_fee',
        'total_amount',
        'delivery_type_id',
        'delivery_area_id',
        'delivery_address',
        'delivery_date',
        'delivery_time',
        'status',
        'payment_status',
        'payment_proof',
        'notes',
        'cancellation_reason',
        'assigned_kurir_id',
        'delivery_photo'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'delivery_date' => 'date',
        'delivery_time' => 'datetime:H:i'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryType()
    {
        return $this->belongsTo(DeliveryType::class);
    }

    public function deliveryArea()
    {
        return $this->belongsTo(DeliveryArea::class);
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'assigned_kurir_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }
}
