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
        $title = $this->faker->sentence(10);
        $slug = str($title)->slug();
        $status = $this->faker->randomElement(['draft', 'published']);
        if ($status == 'draft') {
            $published_at = null;
        } else {
            $published_at = $this->faker->dateTimeBetween('-1 week', '+1 week');
        }

        return [
            //
            'title' => $title,
            'slug' => $slug,
            'content' => $this->faker->text(),
            'status' => $status,
            'view_count' => $this->faker->randomNumber(2, true),
            'published_at' => $published_at
        ];
    }
}
