<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'total', 'status', 'shipping_name', 'shipping_phone', 'shipping_address'])]
class Order extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    // Each order belongs to the user who placed it.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // An order is made up of many line items. Call as $order->orderItems.
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
