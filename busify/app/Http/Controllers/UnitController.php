<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TravelPlan;

class UnitController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:unit.index');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchText = trim($request->input('searchText'));
        $units = DB::table('units')
            ->select('units.id', 'units.unit_state', 'units.unit_patent', 'units.unit_brand', 'units.unit_model', 'units.unit_total_capacity', 'units.unit_mileage', 'units.unit_detail')
            ->where('units.unit_patent', 'LIKE', '%' . $searchText . '%')
            ->orderBy('units.unit_state', 'asc')
            ->paginate(5);
        return view('unit.index', compact('units', 'searchText'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $unit = new Unit();
            $unit->unit_patent = $request->input('unit_patent');
            $unit->unit_brand = $request->input('unit_brand');
            $unit->unit_model = $request->input('unit_model');
            $unit->unit_total_capacity = $request->input('unit_total_capacity');
            $unit->unit_mileage = $request->input('unit_mileage');
            $unit->unit_state = Unit::DISPONIBLE;
            $unit->save();
            return redirect()->route('unit.index')->with('success', 'Unidad creada correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('unit.index')->with('error', 'No se pudo crear la unidad.');
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
        $unit = Unit::findOrFail($id);
        if($unit->unit_state == Unit::ASIGNADA){
            return redirect()->route('unit.index')->with('error', 'No se puede editar la unidad porque está asignada a un itinerario.');
        }
        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $unit = Unit::findOrFail($id);
            if($unit->unit_state == Unit::ASIGNADA){
                return redirect()->route('unit.index')->with('error', 'No se puede editar la unidad porque está asignada a un itinerario.');
            }
            if($request->input('unit_state') == 'Disponible'){
                $unit->unit_state = Unit::DISPONIBLE;
            }else if($request->input('unit_state') == 'Desafectada'){
                $unit->unit_state = Unit::DESAFECTADA;
            }
            $unit->unit_patent = $request->input('unit_patent');
            $unit->unit_brand = $request->input('unit_brand');
            $unit->unit_model = $request->input('unit_model');
            $unit->unit_total_capacity = $request->input('unit_total_capacity');
            $unit->unit_mileage = $request->input('unit_mileage');
            $unit->unit_detail = $request->input('unit_detail');
            $unit->save();
        } catch (\Throwable $th) {
            return redirect()->route('unit.index')->with('error', 'No se pudo actualizar la unidad.');
        }

        return redirect()->route('unit.index')->with('success', 'Unidad actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            return redirect()->route('unit.index')->with('error', 'La unidad no se encontró o ya ha sido eliminada.');
        }

        if (!TravelPlan::where('unit_id', $id)->exists()) {
            $unit->delete();
            return redirect()->route('unit.index')->with('success', 'Unidad eliminada correctamente.');
        } else {
            return redirect()->route('unit.index')->with('error', 'No se puede eliminar la unidad porque tiene itinerarios asociados.');
        }
    }

}
