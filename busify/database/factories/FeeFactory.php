<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Fee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cuota>
 */
class FeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $element = [
            Fee::ADEUDADA,
            Fee::PAGA];

        return [
           'fee_amount' => fake()->randomFloat(15, 100, 200),
           'fee_expiration_date' => fake()-> dateTime(),
           'fee_state' => $this->faker->randomElement($element),
        ];
    }
}
