<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\PostCategory;

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
        $st = $this->faker->dateTimeBetween('-6 month', 'now');
        $et = $this->faker->dateTimeBetween($st, '+6 month');

        return [
            'user_id'      => null,
            'title'        => $this->faker->sentence(),
            'slug'         => $this->faker->slug(2),
            'excerpt'      => $this->faker->sentence(6),
            'content'      => $this->faker->randomHtml(),
            'thumbnail'    => null,
            'priority'     => null,
            'is_published' => $this->faker->boolean(),
            'published_at' => $st,
            'expired_at'   => $this->faker->boolean() ? $et : null,
        ];
    }

    /**
     * Test User
     */
    public function test(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => 1,
        ]);
    }

    /**
     * Uncategorized category
     */
    public function uncategorized(): static
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => 1,
        ]);
    }
}
