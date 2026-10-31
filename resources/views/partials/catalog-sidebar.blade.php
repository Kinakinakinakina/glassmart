{{-- Left catalog rail: search + category menu, each a little Win7 window. --}}
<x-window title="Search the shop">
    <form class="aero-sidesearch" method="GET" action="{{ route('products.index') }}">
        <input type="search" name="q" value="{{ $search }}" placeholder="find stuff…" aria-label="Search">
        <button class="aero-btn aero-btn--sm" type="submit">Go</button>
    </form>
</x-window>

<x-window title="Browse categories" class="aero-pad0">
    <ul class="aero-catnav">
        <li>
            <a class="{{ $activeCategory ? '' : 'active' }}" href="{{ route('products.index') }}">
                <img src="{{ asset('images/orb.png') }}" alt=""> All products
            </a>
        </li>
        @foreach ($categories as $c)
            <li>
                <a class="{{ $activeCategory && $activeCategory->id === $c->id ? 'active' : '' }}"
                   href="{{ route('categories.show', $c) }}">
                    <span class="aero-cat-orb" style="--h: {{ abs(crc32($c->slug)) % 360 }};"></span> {{ $c->name }}
                    <span class="count">{{ $c->products_count ?? '' }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</x-window>
