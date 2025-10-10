<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();
        // User::factory()->create([
        //    'name' => 'Test User',
        //  'email' => 'test@example.com',
        //]);

        // Category::create([
        //     'name' => 'Web Programming',
        //     'slug' => 'web-programming',
        // ]);
        // Post::create([
        //     'title' => 'Judul Artikel Pertama',
        //     'slug' => 'judul-artikel-pertama',
        //     'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.',
        //     'author_id' => 1,
        //     'category_id' => 1,
        // ]);


        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
        ]);
        Post::factory(100)->recycle([
            Category::all(),
            User::all(),
        ])->create();

    }
}
