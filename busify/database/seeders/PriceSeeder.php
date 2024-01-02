<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Price::create([
            'service_type' => Service::COMPLETO,
            'price_per_km' => 4000.0,
            'discount_per_aditional_passenger' => 10.0,
        ]);

        \App\Models\Price::create([
            'service_type' => Service::SEMICOMPLETO,
            'price_per_km' => 4500.0,
            'discount_per_aditional_passenger' => 5.0,
        ]);
    }
}
