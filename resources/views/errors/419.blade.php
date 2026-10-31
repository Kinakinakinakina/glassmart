@extends('layouts.app')

@section('title', '419 — GlassMart')

@section('content')
    <div style="max-width:520px;margin:0 auto;">
        <x-window title="419 — Page expired">
            <p style="margin-top:0;font-size:15px;">Your session got a little too glossy and expired.</p>
            <p class="muted">Please go back, refresh the page, and try again.</p>
            <div class="aero-hero-actions" style="margin-top:14px;">
                <a class="aero-btn aero-btn--primary" href="{{ route('home') }}">Back to home</a>
            </div>
        </x-window>
    </div>
@endsection
