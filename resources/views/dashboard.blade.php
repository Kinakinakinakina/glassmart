@extends('layouts.app')

@section('title', 'Dashboard — GlassMart')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Your dashboard</h1>
        <p>
            Signed in as <strong>{{ auth()->user()->name }}</strong>
            ({{ auth()->user()->email }}) — role: <strong>{{ auth()->user()->role }}</strong>.
        </p>

        @if (auth()->user()->isAdmin())
            <a class="btn btn-primary" href="{{ route('admin.dashboard') }}">Open admin panel</a>
        @else
            <p class="muted">Browse the store and track your orders here (coming in the next steps).</p>
        @endif
    </div>
@endsection
