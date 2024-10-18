<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Theater>
 */
class TheaterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         // Define an array of major cities and their corresponding states
         $citiesAndStates = [
            ['city' => 'Los Angeles', 'state' => 'CA'],
            ['city' => 'New York', 'state' => 'NY'],
            ['city' => 'Chicago', 'state' => 'IL'],
            ['city' => 'Houston', 'state' => 'TX'],
            ['city' => 'Phoenix', 'state' => 'AZ'],
            ['city' => 'Philadelphia', 'state' => 'PA'],
            ['city' => 'San Antonio', 'state' => 'TX'],
            ['city' => 'San Diego', 'state' => 'CA'],
            ['city' => 'Dallas', 'state' => 'TX'],
            ['city' => 'San Jose', 'state' => 'CA'],
        ];

        // Select a random city-state pair
        $location = $this->faker->randomElement($citiesAndStates);

        return [
           'name' => $this->faker->company,    // Fake theater name
            'city' => $location['city'],        // Random city from the predefined list
            'state' => $location['state'], 
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }
}
