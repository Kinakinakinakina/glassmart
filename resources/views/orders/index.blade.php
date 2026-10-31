@extends('layouts.app')

@section('title', 'My orders — GlassMart')

@section('content')
    <x-window title="My orders">
        @if ($orders->isEmpty())
            <p>You haven't placed any orders yet. <a href="{{ route('products.index') }}">Start shopping</a>.</p>
        @else
            <div class="aero-table-wrap">
                <table class="aero-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="num">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td><span class="aero-pill aero-pill--{{ $order->status }}">{{ $order->status }}</span></td>
                                <td class="num">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td><a href="{{ route('orders.show', $order) }}">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-window>
@endsection
