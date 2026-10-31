{{-- Right-hand "fun" rail — the neocities furniture that fills the empty space:
     shop profile, who's-online, newsletter, trust and an under-construction sign.
     Each is a little Win7 window. $newArrivals is optional (home page only). --}}

@isset($newArrivals)
    @if ($newArrivals->isNotEmpty())
        <x-window title="New arrivals" class="aero-pad0">
            <ul class="aero-rail">
                @foreach ($newArrivals as $p)
                    <li>
                        <a href="{{ route('products.show', $p) }}">
                            <span class="thumb"><img src="{{ $p->imageUrl() }}" alt=""></span>
                            <span class="name">{{ $p->name }}</span>
                            <span class="price">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </x-window>
    @endif
@endisset

<x-window title="About this shop">
    <div class="aero-profile">
        <span class="pfp"><img src="{{ asset('images/orb.png') }}" alt=""></span>
        <span class="meta">
            <b>GlassMart</b><br>
            <small>Open since 2009 &middot; still glossy</small>
        </span>
    </div>
    <p class="muted" style="margin:9px 0 0;">
        Your corner shop for gadgets, games, toys &amp; media from the shiniest decade.
        Grab a bubble tea and browse. :)
    </p>
</x-window>

<x-window title="Who's online">
    <ul class="aero-onlinelist">
        <li><span class="aero-online-dot"></span> <strong class="aero-online-num">12</strong>&nbsp;glass-gazers browsing</li>
        <li><span class="aero-online-dot"></span> xX_bubblz_Xx is window-shopping</li>
        <li><span class="aero-online-dot"></span> psp_fan_2007 added a Wii</li>
        <li><span class="aero-online-dot"></span> you! o/</li>
    </ul>
</x-window>

@include('partials.widget-email')
@include('partials.widget-trust')

<x-window title="Pardon our pixels">
    <img class="aero-underconstruction" src="{{ asset('images/badges/underconstruct.gif') }}" alt="Under construction">
    <p class="muted" style="margin:8px 0 0; text-align:center;">Parts of GlassMart are still being built!</p>
</x-window>
