@extends('layouts.app')

@section('title', 'Order #'.$order->id.' — GlassMart')

@section('content')
    <p><a class="muted" href="{{ route('orders.index') }}">&larr; Back to my orders</a></p>

    <x-window title="Order #{{ $order->id }}">
        <p class="muted" style="margin-top:0;">
            Placed {{ $order->created_at->format('d M Y, H:i') }} — status:
            <span class="aero-pill aero-pill--{{ $order->status }}">{{ $order->status }}</span>
        </p>

        <h2>Items</h2>
        <div class="aero-table-wrap">
            <table class="aero-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="num">Unit price</th>
                        <th>Qty</th>
                        <th class="num">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="num">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="num">Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="aero-total">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</div>

        <h2 style="margin-top:22px;">Shipping</h2>
        <p>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address }}
        </p>
    </x-window>
@endsection
