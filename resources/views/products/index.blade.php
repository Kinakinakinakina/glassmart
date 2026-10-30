@extends('layouts.app')

@section('title', $activeCategory ? $activeCategory->name.' — GlassMart' : 'Shop — GlassMart')

@section('content')
    <h1 style="margin-top:0;">{{ $activeCategory?->name ?? 'All products' }}</h1>

    <div style="margin-bottom:16px;display:flex;flex-wrap:wrap;gap:8px;">
        <a class="btn" href="{{ route('products.index') }}">All</a>
        @foreach ($categories as $category)
            <a class="btn" href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
        @endforeach
    </div>

    <form method="GET" action="{{ route('products.index') }}" style="margin-bottom:18px;display:flex;gap:8px;">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search products..." style="max-width:280px;">
        <button class="btn" type="submit">Search</button>
    </form>

    @if ($products->isEmpty())
        <div class="card">No products found.</div>
    @else
        <div class="grid">
            @foreach ($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>

        <div style="margin-top:18px;">{{ $products->links() }}</div>
    @endif
@endsection
