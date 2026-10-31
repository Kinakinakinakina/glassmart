@extends('layouts.app')

@section('title', 'Checkout — GlassMart')

@section('content')
    @if ($errors->any())
        <div class="aero-flash aero-flash--error">{{ $errors->first() }}</div>
    @endif

    <div style="margin-bottom:14px;">
        <x-window title="Order summary">
            @foreach ($items as $item)
                <div style="display:flex;justify-content:space-between;padding:4px 0;">
                    <span>{{ $item['product']->name }} &times; {{ $item['quantity'] }}</span>
                    <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                </div>
            @endforeach
            <div class="aero-total">Total: Rp {{ number_format($total, 0, ',', '.') }}</div>
        </x-window>
    </div>

    <x-window title="Shipping details">
        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <label for="shipping_name">Full name</label>
            <input id="shipping_name" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required>
            @error('shipping_name') <div class="aero-error">{{ $message }}</div> @enderror

            <label for="shipping_phone">Phone</label>
            <input id="shipping_phone" name="shipping_phone" type="tel" value="{{ old('shipping_phone') }}" required>
            @error('shipping_phone') <div class="aero-error">{{ $message }}</div> @enderror

            <label for="shipping_address">Address</label>
            <input id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required>
            @error('shipping_address') <div class="aero-error">{{ $message }}</div> @enderror

            <div style="margin-top:18px;">
                <button class="aero-btn aero-btn--grass" type="submit">Place order (simulated payment)</button>
            </div>
        </form>
    </x-window>
@endsection
