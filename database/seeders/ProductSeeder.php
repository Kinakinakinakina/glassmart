<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Prices are in IDR (whole rupiah); stored as decimal(10,2).
        $productsByCategory = [
            'gadgets' => [
                ['name' => 'iPod Classic 160GB', 'price' => 1850000, 'stock' => 12, 'description' => 'The last click-wheel iPod. Carry 40,000 songs in your pocket.'],
                ['name' => 'iPod Nano 5th Gen', 'price' => 950000, 'stock' => 20, 'description' => 'Pocket-sized music with a built-in video camera and FM radio.'],
                ['name' => 'Sony PSP-3000', 'price' => 1250000, 'stock' => 15, 'description' => 'Handheld PlayStation power with a crisp widescreen display.'],
                ['name' => 'Nintendo DSi', 'price' => 1100000, 'stock' => 10, 'description' => 'Dual screens, two cameras, and the DSi Shop.'],
                ['name' => 'Motorola RAZR V3', 'price' => 750000, 'stock' => 8, 'description' => 'The iconic ultra-thin flip phone that defined cool.'],
                ['name' => 'Zune HD 32GB', 'price' => 1400000, 'stock' => 6, 'description' => "Microsoft's sleek OLED answer to the iPod touch."],
            ],
            'games-consoles' => [
                ['name' => 'Nintendo Wii Console', 'price' => 2200000, 'stock' => 9, 'description' => 'Motion-controlled fun for the whole living room.'],
                ['name' => 'PlayStation 3 Slim 320GB', 'price' => 3100000, 'stock' => 7, 'description' => 'Blu-ray movies and blockbuster games in one slim box.'],
                ['name' => 'Xbox 360 Elite', 'price' => 2750000, 'stock' => 5, 'description' => 'Xbox LIVE, Halo nights, and that glossy black finish.'],
                ['name' => 'Wii Sports', 'price' => 350000, 'stock' => 30, 'description' => 'Bowling, tennis and boxing — the pack-in that sold the Wii.'],
                ['name' => 'Guitar Hero III: Legends of Rock', 'price' => 450000, 'stock' => 14, 'description' => 'Plastic guitar in hand, living room as a stage.'],
            ],
            'toys' => [
                ['name' => 'Tamagotchi Connection', 'price' => 300000, 'stock' => 25, 'description' => 'Raise, feed and babysit your digital pet on the go.'],
                ['name' => 'Silly Bandz (Pack of 24)', 'price' => 75000, 'stock' => 100, 'description' => 'Shaped rubber bands you wore, traded and collected.'],
                ['name' => 'Beyblade Metal Fusion Starter', 'price' => 180000, 'stock' => 40, 'description' => 'Rip the launcher and let it rip!'],
                ['name' => 'Furby (2012)', 'price' => 650000, 'stock' => 12, 'description' => 'The wide-eyed talking companion, now with an app.'],
                ['name' => 'Nerf Maverick REV-6', 'price' => 250000, 'stock' => 22, 'description' => 'Six-dart revolver for the ultimate indoor skirmish.'],
            ],
            'media' => [
                ['name' => 'Avatar (2009) DVD', 'price' => 120000, 'stock' => 50, 'description' => 'Return to Pandora in the film that redefined the box office.'],
                ['name' => 'The Dark Knight Blu-ray', 'price' => 180000, 'stock' => 35, 'description' => "Why so serious? Nolan's definitive Batman in HD."],
                ['name' => 'Linkin Park - Meteora (CD)', 'price' => 150000, 'stock' => 28, 'description' => 'Nu-metal anthems that ruled every MP3 player.'],
                ['name' => 'Shrek Forever After DVD', 'price' => 110000, 'stock' => 18, 'description' => "The final chapter of everyone's favourite ogre."],
            ],
        ];

        foreach ($productsByCategory as $categorySlug => $products) {
            $category = Category::where('slug', $categorySlug)->firstOrFail();

            foreach ($products as $product) {
                Product::updateOrCreate(
                    ['slug' => Str::slug($product['name'])],
                    [
                        'category_id' => $category->id,
                        'name' => $product['name'],
                        'slug' => Str::slug($product['name']),
                        'description' => $product['description'],
                        'price' => $product['price'],
                        'stock' => $product['stock'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
