<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Payment, User, Movie, Theater};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movie_id' => Movie::inRandomOrder()->value('id') ?? Movie::factory(),
            'theater_id' => Theater::inRandomOrder()->value('id') ?? Theater::factory(),  
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'amount' => $this->faker->numberBetween(5000, 20000),
            'quantity' => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->randomElement([
                '2024-10-18 00:00:00', '2024-10-17 00:00:00', '2024-10-16 00:00:00'
            ]),
            'updated_at' => now(),
        ];
    }
}
