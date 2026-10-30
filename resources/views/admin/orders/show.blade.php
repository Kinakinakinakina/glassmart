@extends('layouts.app')

@section('title', 'Order #'.$order->id.' — Admin')

@section('content')
    <a class="muted" href="{{ route('admin.orders.index') }}">&larr; Back to orders</a>

    <div class="card" style="margin-top:12px;">
        <h1 style="margin-top:0;">Order #{{ $order->id }}</h1>
        <p class="muted">Placed {{ $order->created_at->format('d M Y, H:i') }}</p>

        <form method="POST" action="{{ route('admin.orders.update', $order) }}" style="display:flex;gap:8px;align-items:center;margin:12px 0;">
            @csrf
            @method('PATCH')
            <label for="status" style="margin:0;">Status</label>
            <select id="status" name="status" style="padding:8px 12px;border:1px solid #bcd;border-radius:10px;">
                @foreach (['pending', 'paid', 'shipped', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit">Update status</button>
        </form>

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

        <h2 style="margin-top:20px;">Customer &amp; shipping</h2>
        <p>
            {{ $order->user->name }} ({{ $order->user->email }})<br>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address }}
        </p>
    </div>
@endsection
