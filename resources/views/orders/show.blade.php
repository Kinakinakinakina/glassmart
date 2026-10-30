@extends('layouts.app')

@section('title', 'Order #'.$order->id.' — GlassMart')

@section('content')
    <a class="muted" href="{{ route('orders.index') }}">&larr; Back to my orders</a>

    <div class="card" style="margin-top:12px;">
        <h1 style="margin-top:0;">Order #{{ $order->id }}</h1>
        <p class="muted">
            Placed {{ $order->created_at->format('d M Y, H:i') }} — status: <strong>{{ ucfirst($order->status) }}</strong>
        </p>

        <h2>Items</h2>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:480px;">
                <thead>
                    <tr style="text-align:left;border-bottom:1px solid #cde;">
                        <th style="padding:8px;">Product</th>
                        <th>Unit price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr style="border-bottom:1px solid #eef;">
                            <td style="padding:8px;">{{ $item->product->name }}</td>
                            <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="text-align:right;margin-top:14px;font-weight:700;font-size:18px;">
            Total: Rp {{ number_format($order->total, 0, ',', '.') }}
        </div>

        <h2 style="margin-top:20px;">Shipping</h2>
        <p>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address }}
        </p>
    </div>
@endsection
