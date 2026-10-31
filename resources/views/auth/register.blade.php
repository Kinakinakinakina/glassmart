@extends('layouts.app')

@section('title', 'Register — GlassMart')

@section('content')
    <div class="aero-authwrap">
      <div>
        <x-window title="Create your account">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <label for="name">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
                @error('name') <div class="aero-error">{{ $message }}</div> @enderror

                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                @error('email') <div class="aero-error">{{ $message }}</div> @enderror

                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
                @error('password') <div class="aero-error">{{ $message }}</div> @enderror

                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>

                <div style="margin-top:18px;display:flex;align-items:center;gap:12px;">
                    <button class="aero-btn aero-btn--primary" type="submit">Register</button>
                    <a class="muted" href="{{ route('login') }}">Already have an account?</a>
                </div>
            </form>
        </x-window>
      </div>
    </div>
@endsection
