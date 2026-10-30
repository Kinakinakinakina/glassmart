@extends('layouts.app')

@section('title', 'Edit category — Admin')

@section('content')
    <a class="muted" href="{{ route('admin.categories.index') }}">&larr; Back to categories</a>

    <div class="card" style="margin-top:12px;max-width:520px;">
        <h1 style="margin-top:0;">Edit: {{ $category->name }}</h1>
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @method('PUT')
            @include('admin.categories._form')
            <div style="margin-top:16px;">
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </form>
    </div>
@endsection
