<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory(5)->create()
        Category::create([
            'name' => 'Web Programming',
            'slug' => 'web-programming',
            'color' => 'red',
        ]);
         Category::create([
            'name' => 'UI UX',
            'slug' => 'ui-ux',
            'color' => 'green',
        ]);
        Category::create([
            'name' => 'Mobile Programming',
            'slug' => 'mobile-programming',
            'color' => 'blue',
        ]);
           Category::create([
            'name' => 'Data Structure',
            'slug' => 'data-structure',
            'color' => 'yellow',
        ]);
    }
}
