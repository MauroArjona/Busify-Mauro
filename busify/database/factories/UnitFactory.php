<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Unit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unidad>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $elementos = [Unit::DESAFECTADA, Unit::DISPONIBLE];     
        
        return [            
            'unit_patent' =>strtoupper(fake()->randomLetter()).
                            strtoupper(fake()->randomLetter()).
                            strtoupper(fake()->randomLetter()).
                            strval(fake()->randomNumber(3, true)),
            'unit_total_capacity' => 15,
            'unit_model' => fake()->word(),
            'unit_brand' => fake()->word(),
            'unit_detail' => fake()->text(),
            'unit_mileage' => fake()->numberBetween(1, 100),
            'unit_detail' => fake()->text(100),
            'unit_state' => fake()->randomElement($elementos)
        ];
    }
}
