@extends('layouts.app')

@section('title', $product->name.' — GlassMart')

@section('content')
    <p><a class="muted" href="{{ route('products.index') }}">&larr; Back to shop</a></p>

    <x-window :title="$product->name">
        <div class="product-detail">
            <div class="product-thumb">
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
            </div>

            <div>
                <div class="product-cat">{{ $product->category->name }}</div>
                <div class="product-price" style="font-size:26px;margin-top:4px;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                <p style="margin:14px 0;">{{ $product->description }}</p>

                @if ($product->stock > 0)
                    <span class="aero-pill aero-pill--instock">{{ $product->stock }} in stock</span>
                @else
                    <span class="aero-pill aero-pill--out">Out of stock</span>
                @endif

                @auth
                    @if (auth()->user()->isAdmin())
                        <p class="muted" style="margin-top:18px;">
                            You're signed in as an admin.
                            <a href="{{ route('admin.products.edit', $product) }}">Edit this product</a> in the admin panel.
                        </p>
                    @elseif ($product->stock > 0)
                        <form method="POST" action="{{ route('cart.store', $product) }}" style="margin-top:18px;">
                            @csrf
                            <label for="quantity">Quantity</label>
                            <input id="quantity" name="quantity" type="number" value="1" min="1"
                                   max="{{ $product->stock }}" style="max-width:120px;">
                            @error('quantity') <div class="aero-error">{{ $message }}</div> @enderror
                            <div style="margin-top:14px;">
                                <button class="aero-btn aero-btn--grass" type="submit">Add to cart</button>
                            </div>
                        </form>
                    @endif
                @else
                    <p style="margin-top:18px;">
                        <a class="aero-btn aero-btn--primary" href="{{ route('login') }}">Login to buy</a>
                    </p>
                @endauth
            </div>
        </div>
    </x-window>

    @if ($related->isNotEmpty())
        <div style="margin-top:14px;">
            <x-window title="More in {{ $product->category->name }}">
                <div class="product-grid">
                    @foreach ($related as $relatedProduct)
                        @include('partials.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </x-window>
        </div>
    @endif
@endsection
