@extends('layouts.app')

@section('title', 'Your cart — GlassMart')

@section('content')
    <x-window title="Your cart">
        @if ($items->isEmpty())
            <p>Your cart is empty. <a href="{{ route('products.index') }}">Browse the shop</a>.</p>
        @else
            <div class="aero-table-wrap">
                <table class="aero-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="num">Price</th>
                            <th>Qty</th>
                            <th class="num">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item['product']->name }}</td>
                                <td class="num">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</td>
                                <td>
                                    <form class="aero-qty-form" method="POST" action="{{ route('cart.update', $item['product']) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input name="quantity" type="number" value="{{ $item['quantity'] }}"
                                               min="0" max="{{ $item['product']->stock }}">
                                        <button class="aero-btn aero-btn--sm" type="submit">Update</button>
                                    </form>
                                </td>
                                <td class="num">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('cart.destroy', $item['product']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="linklike" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="aero-total">Total: Rp {{ number_format($total, 0, ',', '.') }}</div>
            <div style="text-align:right;margin-top:14px;">
                <a class="aero-btn aero-btn--grass" href="{{ route('checkout.create') }}">Proceed to checkout &rarr;</a>
            </div>
        @endif
    </x-window>
@endsection
