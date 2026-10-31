@extends('layouts.app')

@section('title', '404 — GlassMart')

@section('content')
    <div style="max-width:520px;margin:0 auto;">
        <x-window title="404 — Page not found">
            <p style="margin-top:0;font-size:15px;">That page drifted off like a bubble — we couldn't find it. :(</p>
            <p class="muted">Check the address, or head back somewhere glossy.</p>
            <div class="aero-hero-actions" style="margin-top:14px;">
                <a class="aero-btn aero-btn--primary" href="{{ route('home') }}">Back to home</a>
                <a class="aero-btn" href="{{ route('products.index') }}">Go shopping</a>
            </div>
        </x-window>
    </div>
@endsection
