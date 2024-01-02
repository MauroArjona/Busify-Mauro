<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use App\Models\TravelPlan;

class DriverController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchText = trim($request->input('searchText'));

        $drivers = Driver::with('user')
            ->where(function ($query) use ($searchText) {
                $query->where('driver_cuil', 'like', "%$searchText%")
                    ->orWhereHas('user', function ($query) use ($searchText) {
                        $query->where('name', 'like', "%$searchText%")
                            ->orWhere('lastName', 'like', "%$searchText%")
                            ->orWhere('driver_state', 'like', "%$searchText%");
                    });
            })
            ->where('driver_state', '!=', 'BAJA')
            ->orderBy('driver_state', 'asc')
            ->paginate(5);

        return view('driver.index', compact('drivers', 'searchText'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $driverId, Request $request)
    {
        $perPage = 5;

        $driver = Driver::with('user')->findOrFail($driverId);

        $searchText = trim($request->input('searchText'));

        return view('driver.show', compact('driver', 'searchText'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $driver = Driver::findOrFail($id);
        $users = User::all();
        return view('driver.edit', compact('driver', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $driver = Driver::findOrFail($id);

        $driver->user->name = $request->input('name');
        $driver->user->lastName = $request->input('lastName');
        $driver->user->dni = $request->input('dni');
        $driver->user->phoneNumber = $request->input('phoneNumber');
        $driver->user->email = $request->input('email');
        $driver->driver_cuil = $request->input('cuil');
        $driver->user->birthdate = $request->input('birthdate');
        $driver->user->address = $request->input('address');

        $driver->user->save();

        return redirect()->route('driver.index')->with('success', 'Chofer actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $driver = Driver::findOrFail($id);
        $travelPlans = TravelPlan::where('driver_id', $id)->get();

        if (!$travelPlans->isEmpty()) {
            return redirect()->route('driver.index')->with('error', 'No se puede eliminar el chofer porque tiene un itinerario asociado.');
        }
        if ($driver->driver_state == Driver::ASIGNADO) {
            return redirect()->route('driver.index')->with('error', 'No se puede eliminar el chofer porque está asignado a un itinerario.');
        }

        $driver->driver_state = Driver::BAJA;
        $driver->save();

        return redirect()->route('driver.index')->with('success', 'Chofer eliminado correctamente');
    }

    public function giveRest(string $id)
    {
        try {
            $driver = Driver::findOrFail($id);
            if (!$driver->travelPlans->isEmpty()) {
                return redirect()->route('driver.index')->with('error', 'No se puede dar franco al chofer porque tiene un itinerario asociado.');
            }
            if ($driver->driver_state == Driver::ASIGNADO) {
                return redirect()->route('driver.index')->with('error', 'No se puede dar franco al chofer porque tiene un itinerario asociado.');
            }
            $driver->driver_state = Driver::DESCANSO;
            $driver->save();
        } catch (\Throwable $th) {
            return redirect()->route('driver.index')->with('error', 'No se pudo dar franco al chofer.');
        }


        return redirect()->route('driver.index')->with('success', 'Franco dado al chofer correctamente.');
    }

    public function enable(string $id)
    {
        try {
            $driver = Driver::findOrFail($id);
            if ($driver->driver_state == Driver::DESCANSO) {
                $driver->driver_state = Driver::DISPONIBLE;
                $driver->save();
            }
        } catch (\Throwable $th) {
            return redirect()->route('driver.index')->with('error', 'No se pudo habilitar al chofer.');
        }

        return redirect()->route('driver.index')->with('success', 'Chofer habilitado correctamente.');
    }

    public function showTravelPlan()
    {
        try {
            $idUser = auth()->user()->id;
    
            // Encuentra al usuario
            $user = User::find($idUser);
    
            // Encuentra al chofer asociado al usuario
            $driver = Driver::find($user->userable_id);
    
            // Encuentra el itinerario asociado al chofer, el más reciente
            $travelPlan = TravelPlan::where('driver_id', $driver->id)->orderBy('created_at', 'desc')->first();
    
            // Verifica si se encontró un itinerario
            
            
            $services = $travelPlan->services()->paginate(5);
            return view('driver.showTravelPlan', compact('travelPlan', 'services'));
        } catch (\Throwable $th) {
            // Define $travelPlan como nulo en caso de error
            return view('driver.showTravelPlan')->with('error', 'Error al mostrar el itinerario');
        }
    }
    
    
}
