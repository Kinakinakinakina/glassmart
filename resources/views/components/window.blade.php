{{--
    Reusable Windows-7 "window" panel (built on the 7.css library).
    Every boxed section on the storefront is one of these, so the site reads
    like a desktop full of little Aero windows (see the neocities references).

    Props:
      title  – caption shown in the title bar
      icon   – kept for backwards-compat but no longer rendered (we dropped the
               emoji icons for a cleaner, more period-accurate look)
      glass  – translucent Aero-glass frame (default true); false = solid chrome
      bright – 7.css light body variant
      bg     – frame colour override (maps to 7.css --w7-w-bg), e.g. "#1f8ff0"
      class  – extra classes merged onto the window-body (via $attributes)

    No Minimize/Maximize/Close buttons here by design — the title bars are just
    captions. (The dismissable ad pop-ups in app.js build their own close [X].)
--}}
@props([
    'title' => '',
    'icon' => null,
    'glass' => true,
    'bright' => false,
    'bg' => null,
])
<div class="window aero-window active {{ $glass ? 'glass' : '' }} {{ $bright ? 'is-bright' : '' }}"
     @if ($bg) style="--w7-w-bg: {{ $bg }};" @endif>
    <div class="title-bar">
        <div class="title-bar-text">{{ $title }}</div>
    </div>
    <div {{ $attributes->merge(['class' => 'window-body has-space']) }}>
        {{ $slot }}
    </div>
</div>
