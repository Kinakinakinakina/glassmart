<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::with('user')->latest()->paginate(15),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load('orderItems.product', 'user');

        return view('admin.orders.show', ['order' => $order]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,paid,shipped,cancelled'],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('status', 'Order #'.$order->id.' marked as '.$data['status'].'.');
    }
}
