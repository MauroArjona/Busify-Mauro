<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:supervisor.index');
    }


    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $supervisors = Supervisor::with('user')
            ->where(function ($query) use ($searchQuery) {
                $query->where('supervisor_cuil', 'like', '%' . $searchQuery . '%')
                    ->orWhereHas('user', function ($query) use ($searchQuery) {
                        $query->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhereHas('user', function ($query) use ($searchQuery) {
                        $query->where('phoneNumber', 'like', '%' . $searchQuery . '%');
                    });
            })
            ->orderBy('supervisor_cuil')
            ->paginate(5);

        return view('supervisor.index', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.registration-supervisor');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $typeEmployee = 'supervisor';


            $lastTypeId = User::where('userable_type', 'App\Models\\' . ucfirst($typeEmployee))->max('userable_id');
            $newTypeId = $lastTypeId + 1;

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



            $newSupervisor = new Supervisor([
                'supervisor_cuil' => $request['cuil'],
                'supervisor_state' => Supervisor::OPERATIVO
            ]);

            $newSupervisor->user($newUser);
            $newSupervisor->save();
            $newUser->assignRole([ucfirst($typeEmployee)]);
            return redirect()->route('supervisor.create')->with('success', 'El supervisor se ha registrado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('supervisor.create')->with('error', 'El supervisor no se ha registrado correctamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $supervisorId, Request $request)
    {
        $perPage = 5;

        $supervisor = Supervisor::with('user')->findOrFail($supervisorId);

        $searchText = trim($request->input('searchText'));

        return view('supervisor.show', compact('supervisor', 'searchText'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supervisor = Supervisor::findOrFail($id);
        $users = User::all();
        return view('supervisor.edit', compact('supervisor', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supervisor = Supervisor::findOrFail($id);

        $supervisor->user->name = $request->input('name');
        $supervisor->user->lastName = $request->input('lastName');
        $supervisor->user->dni = $request->input('dni');
        $supervisor->user->phoneNumber = $request->input('phoneNumber');
        $supervisor->user->email = $request->input('email');
        $supervisor->supervisor_cuil = $request->input('cuil');
        $supervisor->user->birthdate = $request->input('birthdate');
        $supervisor->user->address = $request->input('address');

        $supervisor->user->save();

        return redirect()->route('supervisor.index')->with('success', 'Supervisor actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supervisor = Supervisor::findOrFail($id);
        if ($supervisor->travelPlan()->count() > 0) {
            return redirect()->route('supervisor.index')->with('error', 'El supervisor no puede ser eliminado, tiene itinerarios asignados');
        } else {
            $supervisor->user()->delete();
            $supervisor->delete();
            return redirect()->route('supervisor.index')->with('success', 'Supervisor eliminado correctamente');
        }
    }
}
