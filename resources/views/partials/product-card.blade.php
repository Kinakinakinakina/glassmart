@php($isNew = $isNew ?? false)
<div class="product-card">
    <div class="product-thumb">
        @if ($isNew)
            <span class="aero-sticker aero-sticker--new">NEW!</span>
        @elseif ($product->stock > 0 && $product->stock <= 6)
            <span class="aero-sticker">ONLY<br>{{ $product->stock }}<br>LEFT</span>
        @endif
        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
        <span class="product-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
    </div>
    <div class="product-name">{{ $product->name }}</div>
    <div class="product-cat">{{ $product->category->name ?? '' }}</div>
    @if ($product->stock > 0)
        <span class="aero-pill aero-pill--instock">{{ $product->stock }} in stock</span>
    @else
        <span class="aero-pill aero-pill--out">Out of stock</span>
    @endif
    <a class="aero-btn aero-btn--sm" href="{{ route('products.show', $product) }}">View details</a>
</div>
