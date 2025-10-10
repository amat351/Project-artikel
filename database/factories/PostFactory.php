<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'author_id' => User::Factory(),
            'category_id' => Category::Factory(),
            'slug' => str::slug(fake()->sentence()),
            'body' => fake()->text(250),
            'photo' => 'https://picsum.photos/seed/' . fake()->unique()->uuid() . '/600/400',
        ];
    }
}
