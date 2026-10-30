<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('orders.index', [
            'orders' => auth()->user()->orders()->latest()->get(),
        ]);
    }

    public function show(Order $order): View
    {
        // OrderPolicy::view — a customer may only open their own orders.
        $this->authorize('view', $order);

        $order->load('orderItems.product');

        return view('orders.show', ['order' => $order]);
    }
}
