<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Price;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('services.index');
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
        /* $origin = $request->input('origin'); */ //se lo iba a implementar para el ver desde donde se esta viendo el detalle del servicio, que a travez de la url nos pase si es desde el itinerario o desde la lista de servicios y con un if else mostrar el boton de volver atras  
        $service = Service::findOrFail($id); //busco el servicio
        $passengers = $service->passenger()->get(); //busco pasajeros del servicio
        return view('services.show-service', compact('service', 'passengers'));
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

    public function servicePriceSimulator()
    {
        $prices = Price::all();
        //precio para tipo de servicio
        $priceServiceComplete = Price::where('service_type', 'App\Models\CompleteSrv')->first();
        $priceServiceSemi = Price::where('service_type', 'App\Models\SemicompleteSrv')->first();
        return view('services.service-price-simulator', compact('prices', 'priceServiceComplete', 'priceServiceSemi'));
    }

    public function calculatePrice(Request $request)
    {

        //precio para tipo de servicio
        $priceServiceComplete = Price::where('service_type', 'App\Models\CompleteSrv')->first();
        $priceServiceSemi = Price::where('service_type', 'App\Models\SemicompleteSrv')->first();
        $pricePerKmComplete = $priceServiceComplete->price_per_km;
        $pricePerKmSemi = $priceServiceSemi->price_per_km;
        $discountComplete = $priceServiceComplete->discount_per_aditional_passenger;
        $discountSemi = $priceServiceSemi->discount_per_aditional_passenger;



        $passengerSemi = $request->input('passengerSemi');
        $passengerComplete = $request->input('passengerComplete');
        $distanceSemi = $request->input('distanceSemi');
        $distanceComplete = $request->input('distanceComplete');

        //convertir de texto a float
        $distanceSemi = floatval($distanceSemi);
        $distanceComplete = floatval($distanceComplete);     

        $totalPrice = 0;

        //si alguno de los campos esta vacio, se le asigna 0
        if ($passengerSemi == null) {
            $passengerSemi = 0;
        }
        if ($passengerComplete == null) {
            $passengerComplete = 0;
        }
        if ($distanceSemi == null) {
            $distanceSemi = 0;
        }
        if ($distanceComplete == null) {
            $distanceComplete = 0;
        }

        if ($passengerComplete == 1  && $passengerSemi == 0) {
            $totalPrice = $distanceComplete * $pricePerKmComplete ;
           
        } else if ($passengerComplete > 1 && $passengerSemi == 0) {
            $totalPrice = $distanceComplete * $pricePerKmComplete ;
            $totalPrice = $totalPrice - ($totalPrice * $discountComplete / 100);
        }
        if ($passengerComplete == 0 && $passengerSemi == 1) {
            $totalPrice = $distanceSemi * $pricePerKmSemi;
        } else if ($passengerComplete == 0 && $passengerSemi > 1) {
            $totalPrice = $distanceSemi * $pricePerKmSemi;
            $totalPrice = $totalPrice - ($totalPrice * $discountSemi / 100);
        }
        if ($passengerComplete >= 1 && $passengerSemi >= 1) {
            
            if ($passengerComplete > $passengerSemi) {
                $totalPrice = $distanceComplete * $pricePerKmComplete ;
                $totalPrice += $distanceSemi * $pricePerKmSemi;
                $totalPrice = $totalPrice - ($totalPrice * $discountComplete / 100);
            } else if ($passengerComplete < $passengerSemi) {
                $totalPrice = $distanceComplete * $pricePerKmComplete ;
                $totalPrice += $distanceSemi * $pricePerKmSemi;
                $totalPrice = $totalPrice - ($totalPrice * $discountSemi / 100);
            } else if ($passengerComplete == $passengerSemi) {
                //se aplica el porcentaje de descuento al que tenga mas distancia
                if ($distanceComplete > $distanceSemi) {
                    $totalPrice = $distanceComplete * $pricePerKmComplete ;
                    $totalPrice += $distanceSemi * $pricePerKmSemi;
                    $totalPrice = $totalPrice - ($totalPrice * $discountComplete / 100);
                } else if ($distanceComplete < $distanceSemi) {
                    $totalPrice = $distanceComplete * $pricePerKmComplete ;
                    $totalPrice += $distanceSemi * $pricePerKmSemi;
                    $totalPrice = $totalPrice - ($totalPrice * $discountSemi / 100);
                } else if ($distanceComplete == $distanceSemi) {
                    $totalPrice = $distanceComplete * $pricePerKmComplete ;
                    $totalPrice += $distanceSemi * $pricePerKmSemi;
                    $totalPrice = $totalPrice - ($totalPrice * $discountComplete / 100);
                }
            }
        }

        return view('services.service-price-simulator', compact('totalPrice', 'priceServiceComplete', 'priceServiceSemi'));
    }

    public function addService()
    {
        return view('services.add-service');
    }

    public function loadServiceModal()
    {
    }
    public function listServices(Request $request)
    {
        $searchQuery = $request->input('search');

        $services = Service::where('service_type', 'like', '%' . $searchQuery . '%')
            ->orWhereHas('passenger', function ($query) use ($searchQuery) {
                $query->where('passenger_name', 'like', '%' . $searchQuery . '%');
            })
            ->orWhere('origin_going', 'like', '%' . $searchQuery . '%')
            ->orWhere('destination_going', 'like', '%' . $searchQuery . '%')
            ->orderBy('service_type')
            ->paginate(7);

        return view('services.list-service', compact('services'));
    }
}
