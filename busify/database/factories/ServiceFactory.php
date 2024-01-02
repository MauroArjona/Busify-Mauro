<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Servicio>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $service_types = [Service::COMPLETO, Service::SEMICOMPLETO];

        return [
            'distance' => fake()->randomFloat(3,1,100),
            'origin_going' => fake()->address(),
            'destination_going' => fake()->address(),
            'hour_pickup_going' => fake()->time(),
            'hour_arrival_going' => fake()->time(),
            'destination_return' => fake()->address(),
            'hour_arrival_return' => fake()->time(),
            'service_state' => Service::SIN_ASIGNAR,
            'service_type' => fake()->randomElement($service_types)
        ];
    }
}