<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TravelReport;
use App\Models\TravelPlan;

class TravelReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private const PROB_OCURRENCIA = 0.4; // Probabilidad de que un reporte tenga un kilometraje final.

    public function run(): void
    {        
         // Busco todos los reportes
         $reportes = TravelReport::all();

         // Recorro los reportes, si el reporte actual está asociado a un itinerario con recursos asignados,
         // entonces, con una probabilidad de 0.4, le asigno un kilometraje final y lo guardo.
         // Además cambio el estado del itinerario asociado a ARCHIVADO.
         foreach ($reportes as $reporte) { 
            
            $itinerario = $reporte->travelPlan;

            if (!$itinerario->assistant_id AND !$itinerario->unit_id AND !$itinerario->driver_id 
                AND floatval(mt_rand(0,9) / 100.0) < $this::PROB_OCURRENCIA)
            {             
                $reporte->mileage_end = $reporte->mileage_start + floatval(rand(1,100));
                $itinerario->travel_plan_state = TravelPlan::ARCHIVADO;
                $reporte->save();
                $itinerario->save();
            }
         }    
    }
}
