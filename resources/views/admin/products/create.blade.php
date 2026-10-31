@extends('layouts.app')

@section('title', 'New product — Admin')

@section('content')
    <p><a class="muted" href="{{ route('admin.products.index') }}">&larr; Back to products</a></p>

    <div style="max-width:560px;">
        <x-window title="New product">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @include('admin.products._form')
                <div style="margin-top:16px;">
                    <button class="aero-btn aero-btn--primary" type="submit">Create product</button>
                </div>
            </form>
        </x-window>
    </div>
@endsection
