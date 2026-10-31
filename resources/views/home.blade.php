@extends('layouts.app')

@section('title', 'GlassMart — 2010s Nostalgia Store')

@section('content')
    <section class="aero-hero">
        <h1>Welcome to GlassMart! :)</h1>
        <p>
            The glossiest corner of the 2010s — gadgets, games, toys &amp; media, all wrapped in
            bubbles, sky and wet-glass shine. Technology in harmony with nostalgia™.
        </p>
        <div class="aero-hero-actions">
            <a class="aero-btn aero-btn--grass" href="{{ route('products.index') }}">Start shopping</a>
            @guest
                <a class="aero-btn" href="{{ route('register') }}">Create an account</a>
            @else
                <a class="aero-btn" href="{{ route('dashboard') }}">Go to dashboard</a>
            @endguest
        </div>
    </section>

    <div class="aero-cols3">
        {{-- LEFT: catalog rail (home has no active category / search yet) --}}
        <aside class="aero-col-left">
            @include('partials.catalog-sidebar', ['activeCategory' => null, 'search' => ''])
            @include('partials.shuffle-ad')
        </aside>

        {{-- CENTRE: category tiles + featured grid, each its own window --}}
        <div class="aero-col-main">
            @if (isset($categories) && $categories->isNotEmpty())
                <x-window title="Shop by category">
                    <div class="aero-cat-tiles">
                        @foreach ($categories as $category)
                            <a class="aero-cat-tile" href="{{ route('categories.show', $category) }}">
                                <span class="aero-cat-orb" style="--h: {{ abs(crc32($category->slug)) % 360 }};"></span>
                                <span>{{ $category->name }}</span>
                                <span class="count">{{ $category->products_count ?? '' }} items</span>
                            </a>
                        @endforeach
                    </div>
                </x-window>
            @endif

            @if (isset($featured) && $featured->isNotEmpty())
                <x-window title="Hot picks from the archive">
                    <div class="product-grid">
                        @foreach ($featured as $i => $product)
                            @include('partials.product-card', ['product' => $product, 'isNew' => $i < 4])
                        @endforeach
                    </div>
                </x-window>
            @endif
        </div>

        {{-- RIGHT: the dense "fun" rail --}}
        <aside class="aero-col-right">
            @include('partials.sidebar-right', ['newArrivals' => $newArrivals ?? collect()])
        </aside>
    </div>
@endsection
