@extends('layouts.app')

@section('title', 'Categories — Admin')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <h1 style="margin:0;">Categories</h1>
        <div>
            <a class="muted" href="{{ route('admin.dashboard') }}">&larr; Dashboard</a>
            <a class="btn btn-primary" href="{{ route('admin.categories.create') }}" style="margin-left:10px;">New category</a>
        </div>
    </div>

    <div class="card" style="margin-top:14px;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:520px;">
                <thead>
                    <tr style="text-align:left;border-bottom:1px solid #cde;">
                        <th style="padding:8px;">Name</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr style="border-bottom:1px solid #eef;">
                            <td style="padding:8px;">{{ $category->name }}</td>
                            <td class="muted">{{ $category->slug }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                <form class="inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="margin-left:8px;" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="linklike" type="submit" style="color:#c0392b;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
