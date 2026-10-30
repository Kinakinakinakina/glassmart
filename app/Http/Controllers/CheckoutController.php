<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function create(): View|RedirectResponse
    {
        if ($this->cart->count() < 1) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        return view('checkout.create', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $cartItems = $this->cart->raw();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $data = $request->validated();

        // Everything happens in one transaction: if any stock check fails, the
        // whole order (and every stock decrement) is rolled back.
        $order = DB::transaction(function () use ($cartItems, $data) {
            $products = Product::whereIn('id', array_keys($cartItems))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $lines = [];

            foreach ($cartItems as $productId => $quantity) {
                $product = $products->get($productId);

                if (! $product || ! $product->is_active) {
                    throw ValidationException::withMessages([
                        'cart' => 'A product in your cart is no longer available.',
                    ]);
                }

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'cart' => 'Not enough stock for '.$product->name.' (only '.$product->stock.' left).',
                    ]);
                }

                $total += (float) $product->price * $quantity;

                $lines[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price, // snapshot the price at purchase time
                ];

                $product->decrement('stock', $quantity);
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'pending', // simulated payment; admin can mark it paid/shipped
                'shipping_name' => $data['shipping_name'],
                'shipping_phone' => $data['shipping_phone'],
                'shipping_address' => $data['shipping_address'],
            ]);

            $order->orderItems()->createMany($lines);

            return $order;
        });

        $this->cart->clear();

        return redirect()->route('orders.show', $order)
            ->with('status', 'Order placed! Your order number is #'.$order->id.'.');
    }
}
