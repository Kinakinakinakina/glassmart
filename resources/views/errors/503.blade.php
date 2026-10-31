<!DOCTYPE html>
{{-- Self-contained: during `artisan down` the normal middleware (session/auth)
     is bypassed, so this page must NOT depend on the shared layout. --}}
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Be right back — GlassMart</title>
    <style>
        body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;
            font-family:"Segoe UI", Tahoma, Arial, sans-serif; color:#13364f;
            background:linear-gradient(180deg,#4bb4e6 0%,#9fe0f5 45%,#d9f6e5 72%,#aee66a 100%); }
        .box { max-width:460px; margin:20px; padding:26px 28px; text-align:center;
            background:linear-gradient(to bottom,#ffffff,#e9f3fb);
            border:1px solid #b7d0e6; border-top-color:#fff; border-radius:10px;
            box-shadow:0 14px 28px rgba(0,0,0,.3), 0 10px 10px rgba(0,0,0,.22); }
        h1 { margin:0 0 10px; font-weight:350; font-size:26px; color:#0a4ea0; }
        p { margin:6px 0; font-size:15px; }
        .muted { color:#587890; font-size:13px; }
    </style>
</head>
<body>
    <div class="box">
        <h1>Polishing the glass… :)</h1>
        <p>GlassMart is down for a little maintenance.</p>
        <p class="muted">We'll be back and glossy shortly — thanks for your patience!</p>
    </div>
</body>
</html>
