@extends('layouts.app')

@section('title', 'My orders — GlassMart')

@section('content')
    <h1 style="margin-top:0;">My orders</h1>

    @if ($orders->isEmpty())
        <div class="card">You haven't placed any orders yet. <a href="{{ route('products.index') }}">Start shopping</a>.</div>
    @else
        <div class="card">
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;min-width:480px;">
                    <thead>
                        <tr style="text-align:left;border-bottom:1px solid #cde;">
                            <th style="padding:8px;">Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr style="border-bottom:1px solid #eef;">
                                <td style="padding:8px;">#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td><a href="{{ route('orders.show', $order) }}">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
