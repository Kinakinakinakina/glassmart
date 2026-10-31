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

    // Resolve the best available image for this product, in priority order:
    //   1. an admin-uploaded file (stored under storage/app/public, symlinked
    //      into public/storage),
    //   2. a bundled seed photo named after the slug (public/images/products),
    //   3. a generic glossy placeholder.
    public function imageUrl(): string
    {
        if ($this->image && is_file(public_path('storage/'.$this->image))) {
            return asset('storage/'.$this->image);
        }

        if (is_file(public_path('images/products/'.$this->slug.'.jpg'))) {
            return asset('images/products/'.$this->slug.'.jpg');
        }

        return asset('images/products/_placeholder.png');
    }
}
