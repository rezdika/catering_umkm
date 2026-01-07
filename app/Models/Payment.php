<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'payment_proof',
        'sender_name',
        'verified_by',
        'verified_at',
        'status',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Scope untuk filter status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // Scope untuk filter metode pembayaran
    public function scopeBankTransfer($query)
    {
        return $query->where('payment_method', 'bank_transfer');
    }

    public function scopeQris($query)
    {
        return $query->where('payment_method', 'qris');
    }

    public function scopeCod($query)
    {
        return $query->where('payment_method', 'cod');
    }

    // Accessor untuk format amount
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // Accessor untuk payment method label
    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            'bank_transfer' => 'Bank Transfer',
            'qris' => 'QRIS',
            'cod' => 'Cash on Delivery',
            default => ucfirst(str_replace('_', ' ', $this->payment_method))
        };
    }

    // Accessor untuk status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'verified' => 'bg-success',
            'failed' => 'bg-danger',
            default => 'bg-secondary'
        };
    }
}