<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement(['Forrest Gump', 'Dumb and Dumber', 'Speed']), // Generate a movie title
            'release_date' => $this->faker->dateTimeBetween('-30 years', 'now'), // Random release date
            'rating' => $this->faker->randomElement(['G', 'PG', 'PG-13', 'R', 'NC-17']), // Random rating
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }
}
