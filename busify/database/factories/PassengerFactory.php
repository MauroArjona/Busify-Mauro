<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasajero>
 */
class PassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $grupo_sanguineo = ['A+','A-','B+','B-','AB-','AB+','O-','O+'];

        return [           
            'passenger_dni' => fake()->randomNumber(8, true),
            'passenger_name' => fake()->name(),
            'passenger_last_name' => fake()->lastName(),
            'blood_type' => fake()->randomElement($grupo_sanguineo),
            'disability' => fake()->sentence()
        ];
    }
}
