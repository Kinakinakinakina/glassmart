{{-- Shuffling ad panel — its own tall Win7 window, dropped into the empty
     left-column space under the catalog nav (home page only). It stretches to
     fill the column down to the bottom (see .aero-shuffle-win in app.css). Two
     stacked layers cross-fade (never hard-cut) through the sidead/ images; see
     startSideAds() in app.js. Tall ads overflow on purpose. --}}
@php
    $sideAds = collect(glob(public_path('images/sidead/*.{png,jpg,jpeg,gif,webp}'), GLOB_BRACE) ?: [])
        ->map(fn ($p) => asset('images/sidead/'.basename($p)))
        ->values();
@endphp
@if ($sideAds->isNotEmpty())
    <div class="window aero-window active glass aero-shuffle-win">
        <div class="title-bar">
            <div class="title-bar-text">Sponsored</div>
        </div>
        <div class="window-body has-space aero-pad0">
            <div class="aero-shuffle-ad" aria-hidden="true" data-images='@json($sideAds)'>
                <div class="aero-shuffle-ad-layer is-active"></div>
                <div class="aero-shuffle-ad-layer"></div>
            </div>
        </div>
    </div>
@endif
