@extends('layouts.app')

@section('title', 'Categories — Admin')

@section('content')
    <x-window title="Categories">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:12px;">
            <a class="muted" href="{{ route('admin.dashboard') }}">&larr; Dashboard</a>
            <a class="aero-btn aero-btn--sm aero-btn--primary" href="{{ route('admin.categories.create') }}">New category</a>
        </div>

        <div class="aero-table-wrap">
            <table class="aero-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td class="muted">{{ $category->slug }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                <form class="inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:inline;margin-left:8px;" onsubmit="return confirm('Delete this category?');">
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
    </x-window>
@endsection
