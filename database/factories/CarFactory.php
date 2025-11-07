<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'models' => $this->faker->name(10),
            'brands' => $this->faker->word(5),
            'year' => $this->faker->date('Y-m-d'),
            'colors' => $this->faker->word()

        ];
    }
}
