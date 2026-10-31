@csrf

<label for="name">Name</label>
<input id="name" name="name" value="{{ old('name', $category->name) }}" required>
@error('name') <div class="aero-error">{{ $message }}</div> @enderror

<label for="description">Description</label>
<textarea id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
@error('description') <div class="aero-error">{{ $message }}</div> @enderror
