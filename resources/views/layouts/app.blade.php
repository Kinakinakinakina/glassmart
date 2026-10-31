<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GlassMart')</title>

    {{-- Hand-written CSS + JS, bundled by Vite. The CSS @imports the 7.css
         Windows-7 chrome library; fonts (Segoe UI) are self-hosted. --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- OUTSIDE atmosphere (fixed, behind the whole page). The sky has two
         stacked layers that app.js cross-fades through the original Frutiger
         Aero wallpapers, globbed from public/images/bg/. This is the backdrop
         that shows down both sides of the glass shell. --}}
    @php
        $skyImages = collect(glob(public_path('images/bg/*.{png,jpg,jpeg,gif,webp}'), GLOB_BRACE) ?: [])
            ->map(fn ($p) => asset('images/bg/'.basename($p)))
            ->values();
        // Touhou wallpapers — used INSIDE the shell window (see .aero-winbg below).
        $touhouImages = collect(glob(public_path('images/touhou/*.{png,jpg,jpeg,gif,webp}'), GLOB_BRACE) ?: [])
            ->map(fn ($p) => asset('images/touhou/'.basename($p)))
            ->values();
        $popupAds = collect(glob(public_path('images/popups/*.{png,jpg,jpeg,gif,webp}'), GLOB_BRACE) ?: [])
            ->merge(glob(public_path('images/ads/*.{png,jpg,jpeg,gif,webp}'), GLOB_BRACE) ?: [])
            ->map(fn ($p) => asset(str_contains($p, 'popups') ? 'images/popups/'.basename($p) : 'images/ads/'.basename($p)))
            ->values();
    @endphp
    <div class="aero-sky" aria-hidden="true" data-images='@json($skyImages)'>
        <div class="aero-sky-layer is-active"></div>
        <div class="aero-sky-layer"></div>
    </div>
    <div class="aero-bokeh" aria-hidden="true"></div>
    <div class="aero-bubbles" aria-hidden="true"></div>

    {{-- List of pop-up ad images, globbed from public/images/popups/ (+ the
         legacy ads/ ones). app.js pops them at random; see startAdPopups(). --}}
    <div id="aero-popup-src" data-images='@json($popupAds)' hidden></div>
    <img class="aero-mascot aero-mascot--left" src="{{ asset('images/konata-left.png') }}" alt="" aria-hidden="true">
    <img class="aero-mascot aero-mascot--right" src="{{ asset('images/lucky.png') }}" alt="" aria-hidden="true">

    {{-- Slim top loading sliver — replaces the old full-screen splash so the
         page never gets covered/flashed. app.js fades it out on load. --}}
    <div class="aero-loadbar" aria-hidden="true"></div>

    {{-- THE SHELL: the whole site is one big Windows-7 Aero glass window.
         Capped width + centred ⇒ the wallpaper shows down both sides. --}}
    <div class="aero-shell window glass active">
        <div class="title-bar aero-shell-title">
            <div class="title-bar-text">
                <img src="{{ asset('images/orb.png') }}" alt=""> GlassMart — Technology in harmony with nature™
            </div>
        </div>

        {{-- Toolbar / main nav (glossy Vista menu strip) --}}
        <nav class="aero-toolbar">
            <a class="aero-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/orb.png') }}" alt=""> GlassMart
            </a>
            <div class="aero-toolbar-nav">
                <a href="{{ route('products.index') }}">Shop</a>
                @auth
                    @if (auth()->user()->isAdmin())
                        {{-- Admins are admin-only: just their own panel, no shopping. --}}
                        <a href="{{ route('admin.dashboard') }}">Admin</a>
                    @else
                        <a href="{{ route('cart.index') }}">
                            Cart <span class="aero-cart-count">{{ array_sum(session('cart', [])) }}</span>
                        </a>
                        <a href="{{ route('orders.index') }}">My Orders</a>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    @endif
                    <span class="aero-nav-user">Hi, {{ auth()->user()->name }}</span>
                    <form class="aero-logout" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
                <button id="aero-sound-toggle" class="aero-nav-user" type="button" title="Toggle sound effects">[ sound: off ]</button>
            </div>
        </nav>

        <div class="window-body">
            {{-- Custom Touhou background that lives INSIDE the shell window:
                 two stacked layers app.js cross-fades through the touhou/ images.
                 The shuffled order + current frame persist (sessionStorage) so it
                 stays the same as you move between pages instead of re-rolling. --}}
            <div class="aero-winbg" aria-hidden="true" data-images='@json($touhouImages)'>
                <div class="aero-winbg-layer is-active"></div>
                <div class="aero-winbg-layer"></div>
            </div>

            <div class="container">
                @if (session('status'))
                    <div class="aero-flash">{{ session('status') }}</div>
                @endif

                @yield('content')
            </div>

            <footer class="aero-footer">
                {{-- All the badges + stamps crammed together, centred. --}}
                <div class="aero-badgewall">
                    <img class="aero-footer-sticker" src="{{ asset('images/stamps/sleepy-konata.jpg') }}" alt="">
                    <a href="https://frutigeraeroarchive.org/" target="_blank" rel="noopener">
                        <img src="{{ asset('images/badges/frutigeraeroarchive.png') }}" width="88" height="31" alt="Frutiger Aero Archive">
                    </a>
                    <img src="{{ asset('images/badges/00button.gif') }}" width="88" height="31" alt="">
                    <img src="{{ asset('images/badges/aoki553button.gif') }}" width="88" height="31" alt="">
                    <img src="{{ asset('images/badges/2aa577e6.gif') }}" width="88" height="31" alt="">
                    <img src="{{ asset('images/stamps/cryingfont.png') }}" width="88" height="31" alt="">
                    <img src="{{ asset('images/stamps/dokode.gif') }}" width="88" height="31" alt="">
                    <img src="{{ asset('images/stamps/sugarforbrains.gif') }}" width="88" height="31" alt="">
                    <img src="{{ asset('images/stamps/tamanotchi.gif') }}" width="88" height="31" alt="">
                    <img src="{{ asset('images/stamps/liminal.jpg') }}" width="88" height="31" alt="">
                </div>

                <div class="aero-counter">
                    <span class="aero-online-dot"></span>
                    <span><strong class="aero-online-num">12</strong> glass-gazers online</span>
                    &nbsp;·&nbsp;
                    <span>You are visitor</span>
                    <span class="digits">0042319</span>
                </div>

                <p><small>© {{ date('Y') }} GlassMart · Technology in harmony with nature™ · A 2010s nostalgia store</small></p>
            </footer>
        </div>
    </div>
</body>
</html>
