<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Driver;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chofer>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $elementos = [Driver::ASIGNADO, Driver::BAJA, Driver::DESCANSO, Driver::DISPONIBLE];
        return [            
            'driver_cuil' => rand(25, 30)*1000000000+rand(10000000, 60000000)*10+rand(1,9),
            'driver_start_date' => fake()->dateTime(),
            'driver_state' => $this->randomElement($elementos)
        ];        
    }

    /**
     * funcion que me devuelve un elemento de $elementos en función de la probabilidad de cada uno.
     */
    private function randomElement($elementos): string    
    {
        $probabilidades = [0.2, 0.1, 0.2, 0.5];
        $random = mt_rand() / mt_getrandmax();
        $i = 0;
        $sum = 0;
        while ($sum < $random) {
            $sum += $probabilidades[$i];
            $i++;
        }
        return $elementos[$i - 1];
    }

}
