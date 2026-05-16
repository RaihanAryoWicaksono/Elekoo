<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'subtotal', 'shipping_cost', 'total',
        'status', 'payment_method', 'payment_status',
        'shipping_name', 'shipping_phone', 'shipping_address',
        'shipping_city', 'shipping_province', 'shipping_postal_code', 'notes'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'TN-' . strtoupper(uniqid());
    }

    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending'    => ['text' => 'Menunggu', 'color' => 'yellow'],
            'processing' => ['text' => 'Diproses', 'color' => 'blue'],
            'shipped'    => ['text' => 'Dikirim', 'color' => 'purple'],
            'delivered'  => ['text' => 'Selesai', 'color' => 'green'],
            'cancelled'  => ['text' => 'Dibatalkan', 'color' => 'red'],
            default      => ['text' => 'Unknown', 'color' => 'gray'],
        };
    }
}
