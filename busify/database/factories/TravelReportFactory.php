<?php

namespace Database\Factories;

use App\Models\TravelReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParteDeViaje>
 */
class TravelReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {        
        return [            
            'travel_report_date' => fake()->dateTime(),
            'description' => fake()->text(),            
            'mileage_start' => fake()->randomFloat(1,50000,100000),
        ];
    }
    
}