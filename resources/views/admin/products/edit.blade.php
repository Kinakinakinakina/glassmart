@extends('layouts.app')

@section('title', 'Edit product — Admin')

@section('content')
    <p><a class="muted" href="{{ route('admin.products.index') }}">&larr; Back to products</a></p>

    <div style="max-width:560px;">
        <x-window title="Edit: {{ $product->name }}">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.products._form')
                <div style="margin-top:16px;">
                    <button class="aero-btn aero-btn--primary" type="submit">Save changes</button>
                </div>
            </form>
        </x-window>
    </div>
@endsection
