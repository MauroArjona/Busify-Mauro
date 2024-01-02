<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CurrentAccount;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CuentaCorriente>
 */
class CurrentAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {        
        $puntaje = rand(10, 20)*5;

        $estado = ($puntaje >=50) ? CurrentAccount::HABILITADA : CurrentAccount::SUSPENDIDA;

        return [                        
            'current_account_score' => $puntaje,
            'six_month_counter' => 0,
            'wildcard_counter' => 0,
            'current_account_state' => $estado,
        ];   
        
    }
}
