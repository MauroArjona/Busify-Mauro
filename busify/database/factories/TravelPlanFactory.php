<?php

namespace Database\Factories;

use App\Models\Supervisor;
use App\Models\TravelPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Itinerario>
 */
class TravelPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'travel_plan_name' => fake()->sentence(),
            'passenger_amount' => 0,
            'supervisor_id' => Supervisor::inRandomOrder()->first()->id,
            'travel_plan_state' => TravelPlan::ACTIVO 
        ];
    }
    
    public function randomElement(){        
        return (mt_rand(0, 9) < 8) ? TravelPlan::ACTIVO : TravelPlan::ARCHIVADO;
    }      

}
