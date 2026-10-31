@extends('layouts.app')

@section('title', 'Order #'.$order->id.' — Admin')

@section('content')
    <p><a class="muted" href="{{ route('admin.orders.index') }}">&larr; Back to orders</a></p>

    <x-window title="Order #{{ $order->id }}">
        <p class="muted" style="margin-top:0;">Placed {{ $order->created_at->format('d M Y, H:i') }}</p>

        <form method="POST" action="{{ route('admin.orders.update', $order) }}" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;margin:12px 0;">
            @csrf
            @method('PATCH')
            <label for="status" style="margin:0;">Status</label>
            <select id="status" name="status" style="width:auto;">
                @foreach (['pending', 'paid', 'shipped', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button class="aero-btn aero-btn--sm aero-btn--primary" type="submit">Update status</button>
        </form>

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

        <h2 style="margin-top:20px;">Customer &amp; shipping</h2>
        <p>
            {{ $order->user->name }} ({{ $order->user->email }})<br>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address }}
        </p>
    </x-window>
@endsection
