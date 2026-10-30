@extends('layouts.app')

@section('title', 'GlassMart — 2010s Nostalgia Store')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;color:#0054E3;">Welcome to GlassMart</h1>
        <p>Your portal to the glossiest gadgets, games and toys of the 2010s.</p>

        @guest
            <a class="btn btn-primary" href="{{ route('register') }}">Create an account</a>
            <a class="btn" href="{{ route('login') }}">Login</a>
        @else
            <a class="btn btn-primary" href="{{ route('dashboard') }}">Go to dashboard</a>
        @endguest

        <p class="muted" style="margin-top:18px;">Storefront &amp; catalog arrive in the next steps.</p>
    </div>
@endsection
