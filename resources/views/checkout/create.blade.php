@extends('layouts.app')

@section('title', 'Checkout — GlassMart')

@section('content')
    <h1 style="margin-top:0;">Checkout</h1>

    @if ($errors->any())
        <div class="card" style="border-color:#f5b7b1;background:#fdedec;color:#c0392b;margin-bottom:12px;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card" style="margin-bottom:16px;">
        <h2 style="margin-top:0;">Order summary</h2>
        @foreach ($items as $item)
            <div style="display:flex;justify-content:space-between;">
                <span>{{ $item['product']->name }} &times; {{ $item['quantity'] }}</span>
                <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
            </div>
        @endforeach
        <hr>
        <div style="display:flex;justify-content:space-between;font-weight:700;">
            <span>Total</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="card">
        <h2 style="margin-top:0;">Shipping details</h2>
        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <label for="shipping_name">Full name</label>
            <input id="shipping_name" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required>
            @error('shipping_name') <div class="error">{{ $message }}</div> @enderror

            <label for="shipping_phone">Phone</label>
            <input id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone') }}" required>
            @error('shipping_phone') <div class="error">{{ $message }}</div> @enderror

            <label for="shipping_address">Address</label>
            <input id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required>
            @error('shipping_address') <div class="error">{{ $message }}</div> @enderror

            <div style="margin-top:16px;">
                <button class="btn btn-primary" type="submit">Place order (simulated payment)</button>
            </div>
        </form>
    </div>
@endsection
