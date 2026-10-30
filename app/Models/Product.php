<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['category_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'is_active'])]
class Product extends Model
{
    use HasFactory;

    // Cast DB values to convenient PHP types when reading the model.
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Inverse of Category::products — each product belongs to one category.
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // A product can appear on many order lines over time.
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
