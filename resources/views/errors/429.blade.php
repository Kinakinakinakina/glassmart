@extends('layouts.app')

@section('title', '429 — GlassMart')

@section('content')
    <div style="max-width:520px;margin:0 auto;">
        <x-window title="429 — Too many requests">
            <p style="margin-top:0;font-size:15px;">Whoa, slow down! That's a lot of clicks.</p>
            <p class="muted">Give the bubbles a moment to settle, then try again.</p>
            <div class="aero-hero-actions" style="margin-top:14px;">
                <a class="aero-btn aero-btn--primary" href="{{ route('home') }}">Back to home</a>
            </div>
        </x-window>
    </div>
@endsection
