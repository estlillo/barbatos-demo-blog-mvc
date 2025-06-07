<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
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
            'title' => $this->faker->sentence(6, true),
            'slug' => $this->faker->slug(),
            //'image_path' => $this->faker->imageUrl(640, 480, 'nature', true),
            'excerpt' => $this->faker->paragraph(2, true),
            'content' => $this->faker->paragraphs(20, true),
            'is_published' => $this->faker->boolean(80), // 80% chance of being published
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'user_id' => \App\Models\User::all()->random()->id,
            'category_id' => \App\Models\Category::all()->random()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
