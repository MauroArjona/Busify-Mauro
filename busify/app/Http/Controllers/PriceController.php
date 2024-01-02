<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prices = Price::all();
        return view('price.index', compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $price = Price::findOrFail($id);
        return view('price.edit', compact('price'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
        $price = Price::findOrFail($id);
        $discount = $request->input('discount_per_aditional_passenger');
        $price->price_per_km = $request->input('price_per_km');
        $price->discount_per_aditional_passenger = $discount;
        $price->save();
        return redirect()->route('price.index')->with('success', 'Tarifa actualizada correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('price.index')->with('error', 'Error al actualizar la tarifa.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
