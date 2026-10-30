<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait GeneratesUniqueSlug
{
    /**
     * Build a URL slug from $value that is unique in $table.
     * When editing an existing row, pass its id to $ignoreId so the row
     * does not clash with itself.
     */
    protected function uniqueSlug(string $value, string $table, ?int $ignoreId = null): string
    {
        $base = Str::slug($value);
        $slug = $base;
        $suffix = 2;

        while (
            DB::table($table)
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
