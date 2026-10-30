<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Password is passed in plain text; the User model's 'hashed' cast hashes it on save.
        User::updateOrCreate(
            ['email' => 'admin@glassmart.test'],
            [
                'name' => 'GlassMart Admin',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer@glassmart.test'],
            [
                'name' => 'Demo Customer',
                'password' => 'password',
                'role' => 'customer',
            ]
        );
    }
}
