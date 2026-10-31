@extends('layouts.app')

@section('title', '403 — GlassMart')

@section('content')
    <div style="max-width:520px;margin:0 auto;">
        <x-window title="403 — Forbidden">
            <p style="margin-top:0;font-size:15px;">You don't have permission to view this page. :(</p>
            <p class="muted">This area is for a different kind of account. Let's head back somewhere glossy.</p>
            <div class="aero-hero-actions" style="margin-top:14px;">
                <a class="aero-btn aero-btn--primary" href="{{ route('home') }}">Back to home</a>
                <a class="aero-btn" href="{{ route('products.index') }}">Browse the shop</a>
            </div>
        </x-window>
    </div>
@endsection
