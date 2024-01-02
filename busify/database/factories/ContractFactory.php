<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contract;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contrato>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contract_state = $this->randomState();

        if ($contract_state == Contract::FINALIZADO) {
            return [
                'contract_start_date' => $this->faker->dateTime(),
                'contract_end_date' => now(),
                'contract_montly_fee' => fake()->randomFloat(15,20000,60000),
                'contract_state' => $contract_state
            ];    
        }
        else{
            return [
                'contract_start_date' => fake()->dateTime(),
                'contract_end_date' => fake()->dateTimeBetween('-1 months', '+3 months'),
                'contract_montly_fee' => fake()->randomFloat(15,20000,60000),
                'contract_state' => $contract_state
            ];
        }
    }

    private function randomState()
    {
        $prob = fake()->randomDigit();
        if ($prob==0) return Contract::FINALIZADO;        
        else if ($prob==1) return Contract::ESPERANDO_APROBACION;        
        else if ($prob==2) return Contract::FINALIZADO_CON_DEUDA;
        else if ($prob==3) return Contract::PAUSADO;        
        else return Contract::HABILITADO;
    }
}
