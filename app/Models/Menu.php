<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'stock',
        'tags',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'tags' => 'array',
        'is_active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopePopular($query, $limit = 6)
    {
        return $query->select('menus.*', \DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->leftJoin('order_items', 'menus.id', '=', 'order_items.menu_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('menus.is_active', true)
            ->where('menus.stock', '>', 0)
            ->where(function($query) {
                $query->whereIn('orders.status', ['completed', 'delivered'])
                      ->orWhereNull('orders.status');
            })
            ->groupBy('menus.id')
            ->orderBy('total_sold', 'desc')
            ->limit($limit);
    }
}
