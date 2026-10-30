<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * The shopping cart lives in the session as [product_id => quantity].
 * We deliberately store only ids and quantities — never prices — so product
 * prices and stock are always read live from the database and cannot be
 * tampered with through the session.
 */
class CartService
{
    private const KEY = 'cart';

    public function add(int $productId, int $quantity = 1): void
    {
        $cart = $this->raw();
        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
        $this->save($cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->raw();

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }

        $this->save($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->raw();
        unset($cart[$productId]);
        $this->save($cart);
    }

    public function clear(): void
    {
        session()->forget(self::KEY);
    }

    /** @return array<int,int> product_id => quantity */
    public function raw(): array
    {
        return session()->get(self::KEY, []);
    }

    public function count(): int
    {
        return array_sum($this->raw());
    }

    /**
     * Build line items by loading the live products for the ids in the cart.
     *
     * @return Collection<int,array{product:Product,quantity:int,subtotal:float}>
     */
    public function items(): Collection
    {
        $cart = $this->raw();

        if (empty($cart)) {
            return collect();
        }

        return Product::whereIn('id', array_keys($cart))
            ->get()
            ->map(fn (Product $product) => [
                'product' => $product,
                'quantity' => $cart[$product->id],
                'subtotal' => (float) $product->price * $cart[$product->id],
            ]);
    }

    public function total(): float
    {
        return (float) $this->items()->sum('subtotal');
    }

    private function save(array $cart): void
    {
        session()->put(self::KEY, $cart);
    }
}
