@extends('layouts.app')

@section('title', 'Products — Admin')

@section('content')
    <x-window title="Products">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:12px;">
            <a class="muted" href="{{ route('admin.dashboard') }}">&larr; Dashboard</a>
            <a class="aero-btn aero-btn--sm aero-btn--primary" href="{{ route('admin.products.create') }}">New product</a>
        </div>

        <div class="aero-table-wrap">
            <table class="aero-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th class="num">Price</th>
                        <th>Stock</th>
                        <th>Active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td class="num">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <span class="aero-pill aero-pill--{{ $product->is_active ? 'instock' : 'out' }}">
                                    {{ $product->is_active ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.products.edit', $product) }}">Edit</a>
                                <form class="inline" method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display:inline;margin-left:8px;" onsubmit="return confirm('Delete this product?');">
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

        <div style="margin-top:14px;">{{ $products->links('partials.pagination') }}</div>
    </x-window>
@endsection
