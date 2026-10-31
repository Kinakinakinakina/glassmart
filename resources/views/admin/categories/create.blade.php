@extends('layouts.app')

@section('title', 'New category — Admin')

@section('content')
    <p><a class="muted" href="{{ route('admin.categories.index') }}">&larr; Back to categories</a></p>

    <div style="max-width:520px;">
        <x-window title="New category">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @include('admin.categories._form')
                <div style="margin-top:16px;">
                    <button class="aero-btn aero-btn--primary" type="submit">Create category</button>
                </div>
            </form>
        </x-window>
    </div>
@endsection
