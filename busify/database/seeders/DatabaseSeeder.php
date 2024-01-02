<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assistant;
use App\Models\User;
use App\Models\CurrentAccount;
use App\Models\Passenger;
use App\Models\Unit;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Fee;
use App\Models\Service;
use App\Models\Payment;
use App\Models\Driver;
use App\Models\TravelPlan;
use App\Models\TravelReport;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    private const CANT_USUARIOS = 150; // Cantidad de usuarios a agregar en la BD.
    private const CANT_ASISTENTES = 25; // Cantidad de asistentes a agregar en la BD.
    private const CANT_UNIDADES = 25; // Cantidad de unidades a agregar en la BD.
    private const CANT_CHOFERES_LIBRES = 4;
    private const CANT_ASISTENTES_LIBRES = 4;
    private const CANT_UNIDADES_LIBRES = 4;
    private const PROB_ITINERARIO = 0.20; // Probabilidad que el itinerario quede sin asignarle recursos.
    private const MIN_SERVICIOS = 5; // Cantidad mínima de servicios asignables a un itinerario.
    private const MAX_SERVICIOS = 10; // Cantidad máxima de servicios asignables a un itinerario.
    /**
     * Seed the application's database.
     */
    public function run(): void
    {      
        // Lleno las tablas User, Client, Driver y Supervisor con datos aleatorios
        User::factory($this::CANT_USUARIOS)->create();

        // Llamo al Seeder de Role para crear roles y permisos
        $this -> call(RoleSeeder::class);

        // Llamo al Seeder de User para crear usuarios customizados y asignarles roles a todos los usuarios
        $this -> call(UserSeeder::class);

        // Lleno la tabla Assistant con datos aleatorios. 
        Assistant::factory($this::CANT_ASISTENTES)->create();

        // Lleno la tabla Unit con datos aleatorios
        Unit::factory($this::CANT_UNIDADES)->create(); 
        
        // Levanto todos los clientes registrados en la tabla Cliente
        $variosClientes = Client::all();
       
        // Por cada cliente
        foreach ($variosClientes as $unCliente){

            // Creo UN contrato, POR CADA contrato creo entre 1 y 12 cuotas y por cada cuota creo un Pago.
            // Además POR CADA contrato, creo entren 1 y 10 servicios y por cada servicio creo un pasajero.
            // Esto genera un array con instancias de varios modelos, no solamente Contract.
            Contract::factory()
                ->has(CurrentAccount::factory()->has(Fee::factory(rand(1, 12))))
                ->has(Service::factory(rand(1, 10))->has(Passenger::factory()))
                ->create(); 
            
            // Busco un contrato sin cliente asignado
            $unContrato = Contract::where('client_id', null)               
                ->get()
                ->first(); 

            // Asigno el contrato encontrado al cliente actual.
            $unContrato->client_id = $unCliente->id;            
            
            // Actualizo el contrato.         
            $unContrato->save();                          
        }
        // Cargo todos los servicios sin asignar en un array
        $servicios = Service::where('service_state', Service::SIN_ASIGNAR)
            ->inRandomOrder()
            ->get();                        

        // Genero una cantidad aleatoria de elementos a crear
        $cantServiciosParaASignar = rand($this::MIN_SERVICIOS, $this::MAX_SERVICIOS);

        while ($servicios->count() > $cantServiciosParaASignar)
        {                
            if (floatval(rand(1,100))/100.0 <= $this::PROB_ITINERARIO)
            {
                // creo UN itinerario sin asignarle un reporte, eventos, un chofer, una unidad
                // y sin asistente.
                $itinerario = TravelPlan::factory()->create();
            } 
            else
            {        
                // creo UN itinerario, por cada itinerario creo entre 1 a 10 partes de viaje
                // y por cada parte de viaje creo entre 1 a 10 eventos.
                $itinerario = TravelPlan::factory()
                ->has(TravelReport::factory(rand(1,10))->has(Event::factory(rand(1,10))))
                    ->create();               

                // Le asigno un chofer
                $choferes = Driver::where('driver_state', Driver::DISPONIBLE)
                    ->inRandomOrder()
                    ->get();               
                    
                if ($choferes->count() > $this::CANT_CHOFERES_LIBRES)    
                {
                    $unChofer = $choferes->first(); 
                    $itinerario->driver_id = $unChofer->id;
                    $itinerario->save();
                    $unChofer->driver_state = Driver::ASIGNADO;                    
                    $unChofer->save();
                }                     

                // Le asigno un asistente
                $asistentes = Assistant::where('assistant_state', Assistant::DISPONIBLE)                    
                    ->inRandomOrder()
                    ->get();          

                if ($asistentes->count() > $this::CANT_ASISTENTES_LIBRES)
                {
                    $unAsistente = $asistentes->pop();                     
                    $itinerario->assistant_id = $unAsistente->id;          
                    $unAsistente->assistant_state = Assistant::ASIGNADO;                    
                    $unAsistente->save();
                }
                
                // Le asigno una unidad
                $unidades = Unit::where('unit_state', Unit::DISPONIBLE)                    
                    ->inRandomOrder()
                    ->get();
                         
                if ($unidades->count() > $this::CANT_UNIDADES_LIBRES)
                {
                    $unaUnidad = $unidades->pop();                 
                    $itinerario->unit_id = $unaUnidad->id;
                    $unaUnidad->unit_state = Unit::ASIGNADA;  
                    $unaUnidad->save();                  
                }                
            }
            // Mientras haya elementos a procesar saco servicios y los
            // asigno al itinerario actual.
            while ($cantServiciosParaASignar > 0)
            {       
                // Tomo un servicio para procesarlo
                $servicio = $servicios->pop();
                // Asocio el servicio con el itinerario recién creado
                $servicio->travel_plan_id = $itinerario->id;   
                // Cambio el estado del servicio procesado               
                $servicio->service_state = Service::ASIGNADO;
                // Salvo los cambios que se efectuaron en el servicio                    
                $servicio->save();                          
                // Disminuyo la cantidad de elementos a procesar.   
                $cantServiciosParaASignar--;
                // Incremento en uno la cantidad de pasajeros del itinerario
                $itinerario->passenger_amount++;
                // Salvo los cambios que se efectuaron en el itinerario
                $itinerario->save();
            }  
            
            // Persisto el Itinerario en la BD
            $itinerario->save();

            // Actualizo el array con servicios en estado SIN_ASIGNAR
            $servicios = Service::where('service_state', Service::SIN_ASIGNAR)
                ->inRandomOrder()
                ->get(); 

            // Actualizo la cantidad de servicios a asignar a un itinerario
            $cantServiciosParaASignar = rand($this::MIN_SERVICIOS, $this::MAX_SERVICIOS);    
            
            // 
            $planDeViajes = TravelReport::all();            

            foreach ($planDeViajes as $planDeViaje) {
                $unChofer = Driver::inRandomOrder()->first();                
                $planDeViaje->driver_id = $unChofer->id;
                $planDeViaje->save();
            }

        }
        // Levanto todas las cuotas pagas de la tabla Fee
        $cuotas = Fee::where('fee_state', Fee::PAGA)->get();
        
        // Recorro las cuoas buscando la cuotas pagas para agregar un pago
        foreach ($cuotas as $cuota) {        
            $unPago = Payment::factory()->makeOne(); // Laravel > v10.0 compatibility only
            $unPago->fee_id = $cuota->id;
            $unPago->save();        
        }

        // Ejectuo el Seeder de TravelReport
        $this -> call(TravelReportSeeder::class); 
       
        // Ejecuto el Seeder de Price
        $this -> call(PriceSeeder::class);

    }
}

