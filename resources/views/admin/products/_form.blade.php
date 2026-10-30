@csrf

<label for="name">Name</label>
<input id="name" name="name" value="{{ old('name', $product->name) }}" required>
@error('name') <div class="error">{{ $message }}</div> @enderror

<label for="category_id">Category</label>
<select id="category_id" name="category_id" required style="width:100%;padding:9px 12px;border:1px solid #bcd;border-radius:10px;">
    <option value="">— Select —</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id) === $category->id)>{{ $category->name }}</option>
    @endforeach
</select>
@error('category_id') <div class="error">{{ $message }}</div> @enderror

<label for="price">Price (Rp)</label>
<input id="price" name="price" type="number" step="1" min="0" value="{{ old('price', $product->price) }}" required>
@error('price') <div class="error">{{ $message }}</div> @enderror

<label for="stock">Stock</label>
<input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $product->stock) }}" required>
@error('stock') <div class="error">{{ $message }}</div> @enderror

<label for="description">Description</label>
<textarea id="description" name="description" rows="4" style="width:100%;padding:9px 12px;border:1px solid #bcd;border-radius:10px;">{{ old('description', $product->description) }}</textarea>
@error('description') <div class="error">{{ $message }}</div> @enderror

<label for="image">Image @if ($product->image) (leave empty to keep current) @endif</label>
@if ($product->image)
    <div style="margin-bottom:6px;">
        <img src="{{ asset('storage/'.$product->image) }}" alt="" style="max-height:80px;border-radius:8px;">
    </div>
@endif
<input id="image" name="image" type="file" accept="image/*">
@error('image') <div class="error">{{ $message }}</div> @enderror

<label style="font-weight:400;margin-top:12px;">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active)) style="width:auto;">
    Active (visible in shop)
</label>
