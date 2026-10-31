@extends('layouts.app')

@section('title', 'Orders — Admin')

@section('content')
    <x-window title="Orders">
        <p style="margin-top:0;"><a class="muted" href="{{ route('admin.dashboard') }}">&larr; Dashboard</a></p>

        @if ($orders->isEmpty())
            <p>No orders yet.</p>
        @else
            <div class="aero-table-wrap">
                <table class="aero-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
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
                                <td>{{ $order->user->name }}<br><span class="muted">{{ $order->user->email }}</span></td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td><span class="aero-pill aero-pill--{{ $order->status }}">{{ $order->status }}</span></td>
                                <td class="num">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td><a href="{{ route('admin.orders.show', $order) }}">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:14px;">{{ $orders->links('partials.pagination') }}</div>
        @endif
    </x-window>
@endsection
