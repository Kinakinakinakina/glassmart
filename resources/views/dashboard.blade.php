@extends('layouts.app')

@section('title', 'Dashboard — GlassMart')

@section('content')
    <x-window title="Your dashboard">
        <p style="margin-top:0;">
            Signed in as <strong>{{ auth()->user()->name }}</strong>
            ({{ auth()->user()->email }}) — role: <strong>{{ auth()->user()->role }}</strong>.
        </p>

        <div class="aero-hero-actions" style="margin-top:16px;">
            <a class="aero-btn aero-btn--primary" href="{{ route('products.index') }}">Browse the shop</a>
            <a class="aero-btn" href="{{ route('orders.index') }}">My orders</a>
            @if (auth()->user()->isAdmin())
                <a class="aero-btn aero-btn--grass" href="{{ route('admin.dashboard') }}">Open admin panel</a>
            @endif
        </div>
    </x-window>
@endsection
