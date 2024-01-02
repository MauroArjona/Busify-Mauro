<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Client;


class FeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:fee.index');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $idUser = auth()->user()->id;
            $user = User::find($idUser);
            $client = Client::find($user->userable_id);
            $fees = Fee::where('fee_state', Fee::ADEUDADA)
                ->with('currentAccount.contract')
                ->whereHas('currentAccount.contract', function ($query) use ($client) {
                    $query->where('client_id', $client->id);
                })
                ->get();
        } catch (\Throwable $th) {
            return redirect()->route('fee.index')->with('error', 'Error al buscar cuotas.');
        }

        return view('fee.index', compact('fees'));
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
    public function show(Fee $fee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fee $fee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($feeIds)
    {
        if (rand(1, 10) <= 7) {
            try {
                $feeIdsArray = explode(',', $feeIds);
                $fees = Fee::whereIn('id', $feeIdsArray)->get();

                foreach ($fees as $fee) {
                    $fee->fee_state = Fee::PAGA;
                    $fee->save();

                    $payment = Payment::create([
                        'payment_date' => now(),
                        'payment_amount' => $fee->fee_amount,
                        'fee_id' => $fee->id
                    ]);
                    $payment->save();
                }

                return redirect()->route('fee.index')->with('success', 'Cuota/s pagada/s con éxito');
            } catch (\Exception $e) {
                // Manejar la excepción
                return redirect()->route('fee.index')->with('error', 'Error en el procesamiento del pago');
            }
        } else {
            return redirect()->route('fee.index')->with('error', 'Fallo en el procesamiento del pago');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fee $fee)
    {
        //
    }
}
