@extends('layouts.app')

@section('title', $activeCategory ? $activeCategory->name.' — GlassMart' : 'Shop — GlassMart')

@section('content')
    <div class="aero-cols3">
        {{-- LEFT: search + category menu --}}
        <aside class="aero-col-left">
            @include('partials.catalog-sidebar')
        </aside>

        {{-- CENTRE: the product grid, inside a window titled by the category --}}
        <div class="aero-col-main">
            <x-window :title="$activeCategory?->name ?? 'All products'">
                <p class="muted" style="margin:0 0 12px;">
                    {{ $products->total() }} item{{ $products->total() === 1 ? '' : 's' }}
                    @if ($search) matching “{{ $search }}” @endif
                </p>

                @if ($products->isEmpty())
                    <p>No products found. Try another search or category.</p>
                @else
                    <div class="product-grid">
                        @foreach ($products as $product)
                            @include('partials.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <div style="margin-top:18px;">{{ $products->links('partials.pagination') }}</div>
                @endif
            </x-window>
        </div>

        {{-- RIGHT: the dense "fun" rail (no new-arrivals block on the shop page) --}}
        <aside class="aero-col-right">
            @include('partials.sidebar-right')
        </aside>
    </div>
@endsection
