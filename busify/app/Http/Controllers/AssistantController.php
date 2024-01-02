<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assistant;
use Illuminate\Support\Facades\DB;
use App\Models\TravelPlan;

class AssistantController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:assistant.index');
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $searchText = trim($request->input('searchText'));
        $assistants = DB::table('assistants')
            ->select('assistants.id', 'assistants.assistant_state', 'assistants.assistant_name', 'assistants.assistant_last_name', 'assistants.assistant_cuil')
            ->where(function ($query) use ($searchText) {
                $query->where('assistants.assistant_name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('assistants.assistant_last_name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('assistants.assistant_cuil', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('assistants.assistant_state', 'LIKE', '%' . $searchText . '%');
            })
            ->orderBy('assistants.assistant_name', 'asc')
            ->paginate(5);
        return view('assistants.index', compact('assistants', 'searchText'));
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
    public function show(string $id)
    {
        /*  $assistant = Assistant::findOrFail($id);
        return view('assistants.show', compact('assistant')); */

        //no es necesario los detalles del asistente al utilizar boton modal 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $assistant = Assistant::findOrFail($id);
        return view('assistants.edit', compact('assistant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $assistant = Assistant::findOrFail($id);
        $assistant->assistant_name = $request->input('name');
        $assistant->assistant_last_name = $request->input('lastName');
        $assistant->assistant_cuil = $request->input('cuil');
        $assistant->save();
        return redirect()->route('assistants.index')->with('success', 'Asistente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $assistant = Assistant::findOrFail($id);

        if (TravelPlan::where('assistant_id', '=', $id)->exists()) {
            return redirect()->route('assistants.index')->with('error', 'No se puede eliminar un asistente asignado.');
        } else {
            $assistant->delete();
            return redirect()->route('assistants.index')->with('success', 'Asistente eliminado correctamente.');
        }
        $assistant->delete();
        return redirect()->route('assistants.index')->with('success', 'asistente eliminado correctamente');
    }
}
