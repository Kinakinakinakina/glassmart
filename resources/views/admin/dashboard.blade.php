@extends('layouts.app')

@section('title', 'Admin — GlassMart')

@section('content')
    <x-window title="Admin dashboard">
        <p class="muted" style="margin-top:0;">
            Role-protected area — only users with the <strong>admin</strong> role can see this.
        </p>

        <div class="product-grid" style="margin-top:14px;">
            <div class="aero-glass stat"><b>{{ $productCount }}</b>Products</div>
            <div class="aero-glass stat"><b>{{ $categoryCount }}</b>Categories</div>
            <div class="aero-glass stat"><b>{{ $orderCount }}</b>Orders</div>
            <div class="aero-glass stat"><b>{{ $userCount }}</b>Users</div>
        </div>

        <div style="margin-top:18px;display:flex;flex-wrap:wrap;gap:8px;">
            <a class="aero-btn aero-btn--primary" href="{{ route('admin.products.index') }}">Manage products</a>
            <a class="aero-btn" href="{{ route('admin.categories.index') }}">Manage categories</a>
            <a class="aero-btn" href="{{ route('admin.orders.index') }}">Manage orders</a>
        </div>
    </x-window>
@endsection
