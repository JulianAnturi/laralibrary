<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'isbn' => $this->faker->isbn13(),
            'url' => $this->faker->imageUrl($width = 640, $height = 480, $category = null, $randomize = true, $word = null),
            'state' => $this->faker->optional()->numberBetween(0, 1),
            'quantity' => $this->faker->numberBetween(1, 100),
            'lended' => $this->faker->optional()->numberBetween(0, 0),
            'price' => $this->faker->numberBetween(5000, 100000),
            'sypnosis' => $this->faker->optional()->paragraph(),
        ];
    }
}
