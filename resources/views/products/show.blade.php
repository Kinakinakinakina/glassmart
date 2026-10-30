@extends('layouts.app')

@section('title', $product->name.' — GlassMart')

@section('content')
    <a class="muted" href="{{ route('products.index') }}">&larr; Back to shop</a>

    <div class="card" style="margin-top:12px;">
        <div class="muted">{{ $product->category->name }}</div>
        <h1 style="margin:6px 0;">{{ $product->name }}</h1>
        <div style="font-size:22px;font-weight:700;color:#0054E3;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        <p style="margin-top:12px;">{{ $product->description }}</p>
        <p class="muted">{{ $product->stock > 0 ? $product->stock.' in stock' : 'Out of stock' }}</p>

        @auth
            @if ($product->stock > 0)
                <form method="POST" action="{{ route('cart.store', $product) }}" style="margin-top:12px;">
                    @csrf
                    <label for="quantity">Quantity</label>
                    <input id="quantity" name="quantity" type="number" value="1" min="1" max="{{ $product->stock }}" style="max-width:120px;">
                    @error('quantity') <div class="error">{{ $message }}</div> @enderror
                    <div style="margin-top:12px;">
                        <button class="btn btn-primary" type="submit">Add to cart</button>
                    </div>
                </form>
            @endif
        @else
            <p style="margin-top:12px;"><a class="btn btn-primary" href="{{ route('login') }}">Login to buy</a></p>
        @endauth
    </div>

    @if ($related->isNotEmpty())
        <h2 style="margin-top:24px;">More in {{ $product->category->name }}</h2>
        <div class="grid">
            @foreach ($related as $relatedProduct)
                @include('partials.product-card', ['product' => $relatedProduct])
            @endforeach
        </div>
    @endif
@endsection
