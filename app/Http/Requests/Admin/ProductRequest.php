<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // The route is already restricted to admins by the role:admin middleware.
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ];
    }
}
