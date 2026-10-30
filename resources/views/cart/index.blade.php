@extends('layouts.app')

@section('title', 'Your cart — GlassMart')

@section('content')
    <h1 style="margin-top:0;">Your cart</h1>

    @if ($items->isEmpty())
        <div class="card">Your cart is empty. <a href="{{ route('products.index') }}">Browse the shop</a>.</div>
    @else
        <div class="card">
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;min-width:520px;">
                    <thead>
                        <tr style="text-align:left;border-bottom:1px solid #cde;">
                            <th style="padding:8px;">Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr style="border-bottom:1px solid #eef;">
                                <td style="padding:8px;">{{ $item['product']->name }}</td>
                                <td>Rp {{ number_format($item['product']->price, 0, ',', '.') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('cart.update', $item['product']) }}" style="display:flex;gap:6px;align-items:center;">
                                        @csrf
                                        @method('PATCH')
                                        <input name="quantity" type="number" value="{{ $item['quantity'] }}" min="0" max="{{ $item['product']->stock }}" style="width:72px;">
                                        <button class="btn" type="submit">Update</button>
                                    </form>
                                </td>
                                <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
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

            <div style="text-align:right;margin-top:14px;font-size:18px;font-weight:700;">
                Total: Rp {{ number_format($total, 0, ',', '.') }}
            </div>
            <div style="text-align:right;margin-top:12px;">
                <a class="btn btn-primary" href="{{ route('checkout.create') }}">Proceed to checkout</a>
            </div>
        </div>
    @endif
@endsection
