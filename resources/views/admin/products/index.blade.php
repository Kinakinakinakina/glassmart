@extends('layouts.app')

@section('title', 'Products — Admin')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <h1 style="margin:0;">Products</h1>
        <div>
            <a class="muted" href="{{ route('admin.dashboard') }}">&larr; Dashboard</a>
            <a class="btn btn-primary" href="{{ route('admin.products.create') }}" style="margin-left:10px;">New product</a>
        </div>
    </div>

    <div class="card" style="margin-top:14px;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:680px;">
                <thead>
                    <tr style="text-align:left;border-bottom:1px solid #cde;">
                        <th style="padding:8px;">Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr style="border-bottom:1px solid #eef;">
                            <td style="padding:8px;">{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->is_active ? 'Yes' : 'No' }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.products.edit', $product) }}">Edit</a>
                                <form class="inline" method="POST" action="{{ route('admin.products.destroy', $product) }}" style="margin-left:8px;" onsubmit="return confirm('Delete this product?');">
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

        <div style="margin-top:14px;">{{ $products->links() }}</div>
    </div>
@endsection
