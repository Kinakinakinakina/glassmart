@extends('layouts.app')

@section('title', 'New product — Admin')

@section('content')
    <a class="muted" href="{{ route('admin.products.index') }}">&larr; Back to products</a>

    <div class="card" style="margin-top:12px;max-width:560px;">
        <h1 style="margin-top:0;">New product</h1>
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @include('admin.products._form')
            <div style="margin-top:16px;">
                <button class="btn btn-primary" type="submit">Create product</button>
            </div>
        </form>
    </div>
@endsection
