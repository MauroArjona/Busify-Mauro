<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supervisor;
use App\Models\User;
use App\Models\Assistant;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.registration-employees');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $typeEmployee = $request['typeEmployee'];


        $lastTypeId = User::where('userable_type', 'App\Models\\' . ucfirst($typeEmployee))->max('userable_id');
        $newTypeId = $lastTypeId + 1;



        if ($typeEmployee != 'assistant') {
            try{
            $newUser = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'lastName' => $request['lastName'],
                'phoneNumber' => $request['phoneNumber'],
                'birthdate' => $request['birthdate'],
                'address' => $request['address'],
                'dni' => substr($request['cuil'], 2, 8),
                'password' => Hash::make($request['password']),
                'userable_id' => $newTypeId,
                'userable_type' => 'App\Models\\' . ucfirst($typeEmployee),
            ]);
            }catch(\Throwable $th){
                return redirect()->route('employee.create')->with('error', 'El usuario no se ha registrado correctamente.');
            }
        }


        // Create the driver or supervisor
        if ($typeEmployee == 'driver') {
            $newDriver = new Driver([
                'driver_cuil' => $request['cuil'],
                'driver_state' => Driver::DISPONIBLE,
                'driver_start_date' => date("Y/m/d")
            ]);
            try {
                $newDriver->user($newUser);
                $newDriver->save();
                $newUser->assignRole([ucfirst($typeEmployee)]);
            } catch (\Throwable $th) {
                return redirect()->route('employee.create')->with('error', 'El conductor no se ha registrado correctamente.');
            }
            return redirect()->route('employee.create')->with('success', 'El conductor se ha registrado correctamente.');
        } else if ($typeEmployee == 'assistant') {
            $newAssistant = new Assistant([
                'assistant_cuil' => $request['cuil'],
                'assistant_name' => $request['name'],
                'assistant_last_name' => $request['lastName'],
                'assistant_state' => Assistant::DISPONIBLE
            ]);
            try {
                $newAssistant->save();
                return redirect()->route('employee.create')->with('success', 'El asistente se ha registrado correctamente.');
            } catch (\Throwable $th) {
                return redirect()->route('employee.create')->with('error', 'El asistente no se ha registrado correctamente.');
            }
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createSupervisor()
    {
        return view('employee.registration-supervisor');
    }
}
