@extends('layouts.app')

@section('title', 'Login — GlassMart')

@section('content')
    <div class="aero-authwrap">
      <div>
        <x-window title="Login">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                @error('email') <div class="aero-error">{{ $message }}</div> @enderror

                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
                @error('password') <div class="aero-error">{{ $message }}</div> @enderror

                <label style="font-weight:400;margin-top:12px;">
                    <input type="checkbox" name="remember"> Remember me
                </label>

                <div style="margin-top:18px;display:flex;align-items:center;gap:12px;">
                    <button class="aero-btn aero-btn--primary" type="submit">Login</button>
                    <a class="muted" href="{{ route('register') }}">Need an account?</a>
                </div>
            </form>
        </x-window>
      </div>
    </div>
@endsection
