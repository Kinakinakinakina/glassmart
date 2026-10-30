@extends('layouts.app')

@section('title', 'Register — GlassMart')

@section('content')
    <div class="card" style="max-width:440px;margin:0 auto;">
        <h1 style="margin-top:0;">Create your account</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
            @error('name') <div class="error">{{ $message }}</div> @enderror

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>

            <div style="margin-top:18px;">
                <button class="btn btn-primary" type="submit">Register</button>
                <a class="muted" href="{{ route('login') }}" style="margin-left:10px;">Already have an account?</a>
            </div>
        </form>
    </div>
@endsection
