<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email'    => 'admin@taskera.com',
            'mobile'   => '+1234567890',
            'password' => bcrypt('password'),
        ]);

        User::factory(10)->create()->each(function ($user) {
            Post::factory(rand(2, 5))->create([
                'user_id' => $user->id
            ]);
        });
    }
}
