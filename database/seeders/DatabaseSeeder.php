<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         User::factory()->create([
            'name' => 'Writer',
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'is_admin' => '0',
         ]);

         User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'is_admin' => '1',
         ]);

        User::factory()->count(5)->has(Post::factory()->count(3))->create();
    }
}
