<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use App\Models\Driver;
use App\Models\Service;
use App\Models\Supervisor;
use App\Models\TravelPlan;
use App\Models\Unit;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:itinerary.index');
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $searchText = trim($request->input('searchText'));
        $travelPlans = DB::table('travel_plans')
            ->select('travel_plans.id', 'travel_plans.travel_plan_name', 'travel_plans.passenger_amount', 'travel_plans.created_at', 'travel_plans.updated_at')
            ->where('travel_plans.travel_plan_name', 'LIKE', '%' . $searchText . '%')
            ->where('travel_plans.travel_plan_state', '=', 'ACTIVO')
            ->orderBy('travel_plans.created_at', 'asc')
            ->paginate(5);

        return view('itinerary.index', compact('travelPlans', 'searchText'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $searchText = trim($request->input('searchText'));

        $services = Service::where('service_state', Service::SIN_ASIGNAR)
            ->where(function ($query) use ($searchText) {
                $query->where('origin_going', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('destination_going', 'LIKE', '%' . $searchText . '%');
            })
            ->get();

        return view('itinerary.create-itinerary', compact('services', 'searchText'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $idUser = auth()->user()->id;
        $user = User::find($idUser);
        $supervisor = Supervisor::find($user->userable_id);
        try {
            $services = $request->services;
            $travelPlan = TravelPlan::create([
                'travel_plan_name' => $request->itineraryName,
                'passenger_amount' => count($services),
                'supervisor_id' => $supervisor->id,
            ]);
            foreach ($services as $serviceId) {
                $service = Service::findOrFail($serviceId);
                $service->service_state = Service::ASIGNADO;
                $service->travelPlan()->associate($travelPlan);
                $service->save();
            }
            $travelPlan->save();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroyService(string $id)
    {
        //Desvincular servicio del itinerario
        $service = Service::findOrFail($id);
        $travelId = $service->travel_plan_id;
        $service->travel_plan_id = null;
        //Cambiar estado de servicio a sin asignar
        $service->service_state = Service::SIN_ASIGNAR;
        $service->save();
        //Restar uno a la capacidad ocupada del itinerario
        $travelPlan = TravelPlan::findOrFail($travelId);
        $travelPlan->passenger_amount = $travelPlan->passenger_amount - 1;
        $travelPlan->save();
        return redirect()->route('itinerary.edit', $travelId);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $travel_plan_id, Request $request)
    {
        $perPage = 5;

        $travelPlan = TravelPlan::with('supervisor.user', 'driver.user', 'unit', 'assistant')->findOrFail($travel_plan_id);

        $searchText = trim($request->input('searchText'));

        $services = $travelPlan->services()
            ->where(function ($query) use ($searchText) {
                $query->where('origin_going', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('destination_going', 'LIKE', '%' . $searchText . '%');
            })
            ->paginate($perPage);
        return view('itinerary.show', compact('travelPlan', 'services', 'searchText'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $travelPlan = TravelPlan::findOrFail($id);
        $services = $travelPlan->services()->paginate(3);
        //Servicios sin asignar y sin paginado
        $servicesToAssign = Service::where('service_state', Service::SIN_ASIGNAR)->get();
        return view('itinerary.modify-itinerary', compact('travelPlan', 'services', 'servicesToAssign'));

        //return $travelPlan;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $travelPlan = TravelPlan::findOrFail($id);
            $driverId = $request->input('driverSelect');
            $unitId = $request->input('unitSelect');
            $unit = Unit::find($unitId);
            $assistantId = $request->input('assistantSelect');
            if ($driverId == "" || $unitId == "" || $assistantId == "") {
                return redirect()->route('itinerary.allocate-resources', $id)->with('error', 'Debe completar todos los campos.');
            }
            $services = $travelPlan->services()->get();
            $servicesAmount = count($services);
            if ($servicesAmount > $unit->unit_total_capacity) {
                return redirect()->route('itinerary.allocate-resources', $id)->with('error', 'La cantidad de pasajeros supera la capacidad total de la unidad.');
            }
            if ($travelPlan->driver_id != null) {
                $driver = DB::table('drivers')
                    ->where('id', $travelPlan->driver_id)
                    ->update(['driver_state' => Driver::DISPONIBLE]);
            }

            if ($travelPlan->unit_id != null) {
                $unit = DB::table('units')
                    ->where('id', $travelPlan->unit_id)
                    ->update(['unit_state' => Unit::DISPONIBLE]);
            }

            if ($travelPlan->assistant_id != null) {
                $assistant = DB::table('assistants')
                    ->where('id', $travelPlan->assistant_id)
                    ->update(['assistant_state' => Assistant::DISPONIBLE]);
            }
            $idUser = auth()->user()->id;
            $user = User::find($idUser);
            $supervisor = Supervisor::find($user->userable_id);
            $travelPlan->supervisor_id = $supervisor->id;
            $travelPlan->driver_id = $driverId;
            $travelPlan->unit_id = $unitId;
            $travelPlan->assistant_id = $assistantId;

            $driver = DB::table('drivers')
                ->where('id', $driverId)
                ->update(['driver_state' => Driver::ASIGNADO]);
            $unit = DB::table('units')
                ->where('id', $unitId)
                ->update(['unit_state' => Unit::ASIGNADA]);
            $assistant = DB::table('assistants')
                ->where('id', $assistantId)
                ->update(['assistant_state' => Assistant::ASIGNADO]);
            $travelPlan->save();
        } catch (\Throwable $th) {
            return redirect()->route('itinerary.allocate-resources', $id)->with('error', 'No se pudo asignar los recursos.');
        }
        return redirect()->route('itinerary.index')->with('success', 'Itinerario modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $travelPlan = TravelPlan::findOrFail($id);
            //falta sacar los servicios del itinerario
            $services = $travelPlan->services()->get();
            foreach ($services as $service) {
                $service->travel_plan_id = null;
                $service->service_state = Service::SIN_ASIGNAR;
                $service->save();
            }
            //si tiene driver, unit o assistant, quitarles la referencia de la foreign key
            if ($travelPlan->driver_id != null) {
                $driver = DB::table('drivers')
                    ->where('id', $travelPlan->driver_id)
                    ->update(['driver_state' => Driver::DISPONIBLE]);
            }
            if ($travelPlan->unit_id != null) {
                $unit = DB::table('units')
                    ->where('id', $travelPlan->unit_id)
                    ->update(['unit_state' => Unit::DISPONIBLE]);
            }
            if ($travelPlan->assistant_id != null) {
                $assistant = DB::table('assistants')
                    ->where('id', $travelPlan->assistant_id)
                    ->update(['assistant_state' => Assistant::DISPONIBLE]);
            }
            $travelPlan->travel_plan_state = TravelPlan::ARCHIVADO; //En caso de implementar baja lógica
            $travelPlan->save();
            return redirect()->route('itinerary.index')->with('success', 'Itinerario eliminado correctamente.');
        } catch (\Throwable $th) {
            //return $th;
            return redirect()->route('itinerary.index')->with('error', 'No se pudo eliminar el itinerario.' . $th->getMessage());
        }

        return redirect()->route('itinerary.index');
    }

    public function allocateResources(string $id)
    {
        $travelPlan = TravelPlan::with('supervisor.user', 'driver.user', 'unit', 'assistant')->findOrFail($id);
        $services = $travelPlan->services()->get();
        $servicesAmount = count($services);
        $drivers = Driver::where('driver_state', Driver::DISPONIBLE)->get();

        $units = Unit::where('unit_state', Unit::DISPONIBLE)->get();

        $assistants = Assistant::where('assistant_state', Assistant::DISPONIBLE)->get();

        return view('itinerary.allocate-resources', compact('travelPlan', 'drivers', 'units', 'assistants', 'servicesAmount'));
    }

    public function addService(string $idTravelPlan, string $idService)
    {
        $travelPlan = TravelPlan::findOrFail($idTravelPlan);
        $service = Service::findOrFail($idService);

        //Revisar si la unidad del itinerario no tiene ocupada su capacidad total
        if ($travelPlan->unit_id == null) {
            return redirect()->route('itinerary.edit', $idTravelPlan)->with('error', 'Debe asignar una unidad al itinerario.');
        } else
        if ($travelPlan->passenger_amount >= $travelPlan->unit->unit_total_capacity) {
            return redirect()->route('itinerary.edit', $idTravelPlan)->with('error', 'La unidad del itinerario ya tiene ocupada su capacidad total.');
        } else {
        $service->travel_plan_id = $travelPlan->id;
        $service->service_state = Service::ASIGNADO;
        $service->save();
        $travelPlan-> passenger_amount = $travelPlan->passenger_amount + 1;
        $travelPlan->save();     
        return redirect()->route('itinerary.edit', $idTravelPlan)->with('success', 'Servicio agregado correctamente.');
        }
    }

    public function loadServiceModal()
    {
        return view('itinerary.load-service-modal');
    }

    public function deleteService(string $id, Service $service)
    {
        $travelPlan = TravelPlan::findOrFail($id);
        $services = $travelPlan->services();
        $services->detach($service->id);

        return view('itinerary.modify-itinerary', compact('travelPlan', 'services'));
    }
}
