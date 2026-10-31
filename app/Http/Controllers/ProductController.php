<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->where('is_active', true)
            // The search term is passed as a bound parameter, never concatenated
            // into raw SQL, so it is safe from SQL injection.
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->input('q').'%'))
            ->with('category')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => Category::withCount('products')->orderBy('name')->get(),
            'activeCategory' => null,
            'search' => (string) $request->input('q', ''),
        ]);
    }

    public function show(Product $product): View
    {
        abort_if(! $product->is_active, 404);

        $product->load('category');

        $related = Product::where('category_id', $product->category_id)
            ->where('is_active', true)
            ->whereKeyNot($product->id)
            ->limit(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'related' => $related,
        ]);
    }
}
