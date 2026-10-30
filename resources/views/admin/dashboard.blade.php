@extends('layouts.app')

@section('title', 'Admin — GlassMart')

@section('content')
    <div class="card">
        <h1 style="margin-top:0;">Admin dashboard</h1>
        <p class="muted">
            Role-protected area — only users with the <strong>admin</strong> role can see this.
        </p>

        <div class="grid" style="margin-top:18px;">
            <div class="card stat"><b>{{ $productCount }}</b>Products</div>
            <div class="card stat"><b>{{ $categoryCount }}</b>Categories</div>
            <div class="card stat"><b>{{ $orderCount }}</b>Orders</div>
            <div class="card stat"><b>{{ $userCount }}</b>Users</div>
        </div>

        <div style="margin-top:18px;display:flex;flex-wrap:wrap;gap:8px;">
            <a class="btn btn-primary" href="{{ route('admin.products.index') }}">Manage products</a>
            <a class="btn" href="{{ route('admin.categories.index') }}">Manage categories</a>
            <a class="btn" href="{{ route('admin.orders.index') }}">Manage orders</a>
        </div>
    </div>
@endsection
