@csrf

<label for="name">Name</label>
<input id="name" name="name" value="{{ old('name', $category->name) }}" required>
@error('name') <div class="error">{{ $message }}</div> @enderror

<label for="description">Description</label>
<textarea id="description" name="description" rows="3" style="width:100%;padding:9px 12px;border:1px solid #bcd;border-radius:10px;">{{ old('description', $category->description) }}</textarea>
@error('description') <div class="error">{{ $message }}</div> @enderror
