<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Gadgets', 'slug' => 'gadgets', 'description' => 'MP3 players, handhelds, flip phones and other 2010s tech.'],
            ['name' => 'Games & Consoles', 'slug' => 'games-consoles', 'description' => 'Consoles and boxed game titles from the golden era.'],
            ['name' => 'Toys', 'slug' => 'toys', 'description' => 'The playground staples everyone traded and collected.'],
            ['name' => 'Media', 'slug' => 'media', 'description' => 'DVDs, Blu-rays and CDs to complete the throwback.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
