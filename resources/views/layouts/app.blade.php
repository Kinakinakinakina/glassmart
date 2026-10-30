<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GlassMart')</title>
    <style>
        /* Placeholder styling — the full Frutiger Aero design system lands in step 7. */
        :root { --sky:#87CEEB; --aqua:#7EC8E3; --blue:#0054E3; --ink:#123; }
        * { box-sizing: border-box; }
        body { margin:0; font-family:"Segoe UI", Tahoma, sans-serif; color:var(--ink);
               background:linear-gradient(180deg, var(--sky), #eafaff 60%, #ffffff); min-height:100vh; }
        header { display:flex; align-items:center; justify-content:space-between; gap:12px;
                 padding:14px 22px; background:rgba(255,255,255,.65); backdrop-filter:blur(8px);
                 border-bottom:1px solid rgba(255,255,255,.8); flex-wrap:wrap; }
        header .brand { font-weight:700; font-size:20px; color:var(--blue); text-decoration:none; }
        nav a, nav span, nav button { margin-left:14px; font-size:14px; vertical-align:middle; }
        a { color:var(--blue); }
        .container { max-width:960px; margin:28px auto; padding:0 18px; }
        .card { background:rgba(255,255,255,.82); border:1px solid #fff; border-radius:16px;
                padding:24px; box-shadow:0 8px 24px rgba(0,80,200,.12); }
        .btn { display:inline-block; cursor:pointer; border:1px solid var(--blue);
               background:linear-gradient(180deg,#eaf6ff,#bfe3ff); color:var(--blue);
               padding:9px 16px; border-radius:999px; text-decoration:none; font-weight:600; }
        .btn-primary { background:linear-gradient(180deg,#3aa0ff,var(--blue)); color:#fff; }
        label { display:block; margin:12px 0 4px; font-weight:600; font-size:14px; }
        input { width:100%; padding:9px 12px; border:1px solid #bcd; border-radius:10px; font-size:14px; }
        .error { color:#c0392b; font-size:13px; margin-top:4px; }
        .flash { background:#e7fff0; border:1px solid #9be8bf; color:#1a7a46;
                 padding:10px 14px; border-radius:10px; margin-bottom:16px; }
        .muted { color:#567; font-size:13px; }
        form.inline { display:inline; }
        button.linklike { background:none; border:none; color:var(--blue); cursor:pointer; font:inherit; padding:0; }
        .grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:14px; }
        .stat { text-align:center; } .stat b { display:block; font-size:26px; color:var(--blue); }
    </style>
</head>
<body>
    <header>
        <a class="brand" href="{{ route('home') }}">GlassMart</a>
        <nav>
            <a href="{{ route('products.index') }}">Shop</a>
            @auth
                <a href="{{ route('cart.index') }}">Cart ({{ array_sum(session('cart', [])) }})</a>
                <a href="{{ route('orders.index') }}">My orders</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
                <span class="muted">Hi, {{ auth()->user()->name }}</span>
                <form class="inline" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="linklike" type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </nav>
    </header>

    <div class="container">
        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
