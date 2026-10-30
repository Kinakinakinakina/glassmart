@extends('layouts.app')

@section('title', 'Orders — Admin')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <h1 style="margin:0;">Orders</h1>
        <a class="muted" href="{{ route('admin.dashboard') }}">&larr; Dashboard</a>
    </div>

    <div class="card" style="margin-top:14px;">
        @if ($orders->isEmpty())
            <p>No orders yet.</p>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;min-width:620px;">
                    <thead>
                        <tr style="text-align:left;border-bottom:1px solid #cde;">
                            <th style="padding:8px;">Order</th>
                            <th>Customer</th>
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
                                <td>{{ $order->user->name }}<br><span class="muted">{{ $order->user->email }}</span></td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td><a href="{{ route('admin.orders.show', $order) }}">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:14px;">{{ $orders->links() }}</div>
        @endif
    </div>
@endsection
