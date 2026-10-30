<div class="card" style="display:flex;flex-direction:column;gap:6px;">
    <div style="font-weight:600;">{{ $product->name }}</div>
    <div class="muted">{{ $product->category->name ?? '' }}</div>
    <div style="font-weight:700;color:#0054E3;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
    <div class="muted">{{ $product->stock > 0 ? $product->stock.' in stock' : 'Out of stock' }}</div>
    <a class="btn" href="{{ route('products.show', $product) }}">View</a>
</div>
