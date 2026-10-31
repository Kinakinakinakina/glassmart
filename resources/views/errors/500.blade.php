@extends('layouts.app')

@section('title', '500 — GlassMart')

@section('content')
    <div style="max-width:520px;margin:0 auto;">
        <x-window title="500 — Server error">
            <p style="margin-top:0;font-size:15px;">Something fogged up the glass on our end. :(</p>
            <p class="muted">We're on it — please try again in a moment.</p>
            <div class="aero-hero-actions" style="margin-top:14px;">
                <a class="aero-btn aero-btn--primary" href="{{ route('home') }}">Back to home</a>
            </div>
        </x-window>
    </div>
@endsection
