<?php

namespace Database\Factories;

use App\Models\Assistant;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssistantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [           
            'assistant_name' => fake()->name(),
            'assistant_last_name' => fake()->lastName(),
            'assistant_cuil' => rand(20,30)*1000000000 + rand(10000000,60000000)*10 + rand(1,9),
            'assistant_state' => Assistant::DISPONIBLE
        ];
    }
}
