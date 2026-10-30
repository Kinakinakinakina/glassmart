@extends('layouts.app')

@section('title', 'Edit product — Admin')

@section('content')
    <a class="muted" href="{{ route('admin.products.index') }}">&larr; Back to products</a>

    <div class="card" style="margin-top:12px;max-width:560px;">
        <h1 style="margin-top:0;">Edit: {{ $product->name }}</h1>
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.products._form')
            <div style="margin-top:16px;">
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </form>
    </div>
@endsection
