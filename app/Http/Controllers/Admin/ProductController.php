<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\GeneratesUniqueSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    use GeneratesUniqueSlug;

    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::with('category')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product(['is_active' => true]),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['name'], 'products');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->uniqueSlug($data['name'], 'products', $product->id);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // order_items.product_id uses restrictOnDelete, so a product that appears
        // in any order cannot be deleted. Deactivate it instead.
        if ($product->orderItems()->exists()) {
            return back()->with('status', 'Cannot delete a product that appears in orders. Deactivate it instead.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }
}
