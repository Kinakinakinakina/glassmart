@extends('layouts.app')

@section('title', 'Login — GlassMart')

@section('content')
    <div class="card" style="max-width:440px;margin:0 auto;">
        <h1 style="margin-top:0;">Login</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <label style="font-weight:400;margin-top:12px;">
                <input type="checkbox" name="remember" style="width:auto;"> Remember me
            </label>

            <div style="margin-top:18px;">
                <button class="btn btn-primary" type="submit">Login</button>
                <a class="muted" href="{{ route('register') }}" style="margin-left:10px;">Need an account?</a>
            </div>
        </form>

        <p class="muted" style="margin-top:16px;">
            Demo: admin@glassmart.test / customer@glassmart.test — password <code>password</code>
        </p>
    </div>
@endsection
