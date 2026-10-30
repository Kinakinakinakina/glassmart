<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index(): View
    {
        return view('cart.index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        if (! $product->is_active || $product->stock < 1) {
            return back()->with('status', 'Sorry, this product is out of stock.');
        }

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$product->stock],
        ]);

        $this->cart->add($product->id, (int) $data['quantity']);

        return redirect()->route('cart.index')->with('status', $product->name.' added to your cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:'.$product->stock],
        ]);

        $this->cart->update($product->id, (int) $data['quantity']);

        return redirect()->route('cart.index')->with('status', 'Cart updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->cart->remove($product->id);

        return redirect()->route('cart.index')->with('status', 'Item removed from cart.');
    }
}
