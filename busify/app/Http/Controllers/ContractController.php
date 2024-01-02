<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Passenger;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\User;
use App\Models\CurrentAccount;
use App\Models\Price;

class ContractController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchText = $request->input('searchText');

        $contracts = Contract::with('client')
            ->where('contract_start_date', 'like', "%$searchText%")
            ->orWhere('contract_end_date', 'like', "%$searchText%")
            ->orWhere('contract_montly_fee', 'like', "%$searchText%")
            ->orWhere('contract_state', 'like', "%$searchText%")
            ->orWhereHas('client', function ($query) use ($searchText) {
                $query->whereHas('user', function ($query) use ($searchText) {
                    $query->where('name', 'like', "%$searchText%")
                        ->orWhere('lastName', 'like', "%$searchText%");
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(5);

        return view('contract.index', compact('contracts', 'searchText'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contract.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $contrato = new Contract();
            $contrato->client_id = $request->id_cliente;
            $contrato->contract_start_date = Carbon::now();
            $contrato->contract_end_date = Carbon::now()->addMonth($request->cantidadMeses);
            $contrato->contract_montly_fee = 0;
            $contrato->contract_state = Contract::ESPERANDO_APROBACION;
            $contrato->save();

            $serviciosAgregados = $request->servicios;
            $serviciosSemicompletos = 0;
            $serviciosCompletos = 0;
            $kmServicioCompleto = 0;
            $kmServicioSemicompleto = 0;
            //$precioBase = 2000;
            $monto_total = 0;
            $precioKmSemi = Price::where('service_type', 'App\Models\SemicompleteSrv')->first();
            $precioKmCompleto = Price::where('service_type', 'App\Models\CompleteSrv')->first();
            $descuentoSemicompleto = Price::where('service_type', 'App\Models\SemicompleteSrv')->first();
            $descuentoCompleto = Price::where('service_type', 'App\Models\CompleteSrv')->first();

            foreach ($serviciosAgregados as $servicioNuevo) {
                //Crear servicio
                $servicio = new Service();
                $servicio->service_type = $servicioNuevo['tipoServicio'] == "Semicompleto" ? "App\Models\SemicompleteSrv" : "App\Models\CompleteSrv";
                $servicio->service_state = Service::PAUSADO;
                $servicio->distance = $servicioNuevo['distancia'];
                $servicio->origin_going = $servicioNuevo['dirOrigen'];
                $servicio->destination_going = $servicioNuevo['dirEstablecimiento'];
                $servicio->hour_pickup_going = $servicioNuevo['horaRecogida'];
                $servicio->hour_arrival_going = $servicioNuevo['horaLlegada'];
                $servicio->destination_return = $servicioNuevo['dirVuelta'];
                $servicio->hour_arrival_return = $servicioNuevo['horaRetorno'];
                $contrato->services()->save($servicio);


                $precioKmTipoServicio = $servicioNuevo['tipoServicio'] == "Semicompleto" ? $precioKmSemi->price_per_km : $precioKmCompleto->price_per_km;
                $serviciosSemicompletos += $servicioNuevo['tipoServicio'] == "Semicompleto" ? 1 : 0;
                $serviciosCompletos += $servicioNuevo['tipoServicio'] == "Completo" ? 1 : 0;

                $kmServicioCompleto += $servicioNuevo['tipoServicio'] == "Completo" ? $servicioNuevo['distancia'] : 0;
                $kmServicioSemicompleto += $servicioNuevo['tipoServicio'] == "Semicompleto" ? $servicioNuevo['distancia'] : 0;

                $monto_total += ($precioKmTipoServicio * $servicioNuevo['distancia']);

                //Crea pasajero
                $pasajero = new Passenger();
                $pasajero->passenger_name = $servicioNuevo['nombre'];
                $pasajero->passenger_last_name = $servicioNuevo['apellido'];
                $pasajero->passenger_dni = $servicioNuevo['dni'];
                $pasajero->blood_type = $servicioNuevo['grupoSan'];
                $pasajero->disability = $servicioNuevo['discapacidad'];
                $servicio->passenger()->save($pasajero);
            }


            //si hay mas de 1 servicio de distinto tipo, se aplica descuento al que tenga mas pasajeros

            if (($serviciosSemicompletos > $serviciosCompletos) && $serviciosSemicompletos != 1) {
                $monto_total = $monto_total - ($monto_total * ($descuentoSemicompleto->discount_per_aditional_passenger / 100));
            } else if (($serviciosCompletos > $serviciosSemicompletos) && $serviciosCompletos != 1) {
                $monto_total = $monto_total - ($monto_total * $descuentoCompleto->discount_per_aditional_passenger / 100);
            } else if ($serviciosCompletos == $serviciosSemicompletos) {
                if ($kmServicioCompleto > $kmServicioSemicompleto) {
                    $monto_total = $monto_total - ($monto_total * $descuentoCompleto->discount_per_aditional_passenger / 100);
                } else if ($kmServicioSemicompleto > $kmServicioCompleto) {
                    $monto_total = $monto_total - ($monto_total * $descuentoSemicompleto->discount_per_aditional_passenger / 100);
                } else if ($kmServicioCompleto == $kmServicioSemicompleto) {
                    $monto_total = $monto_total - ($monto_total * $descuentoCompleto->discount_per_aditional_passenger / 100);
                }
            }

            $contrato->contract_montly_fee = $monto_total;
            $contrato->save();

            //Crear cuenta corriente para el cliente
            $currentAcount = new CurrentAccount();
            $currentAcount->current_account_score = 60;
            $currentAcount->current_account_state = CurrentAccount::HABILITADA;
            $currentAcount->six_month_counter = 0;
            $currentAcount->wildcard_counter = 0;

            $contrato->currentAccount()->save($currentAcount);
        } catch (\Throwable $th) {
            return redirect()->route('contract.create')->with('error', 'Error al crear el contrato ' . $th->getMessage());
        }
        return route('home');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $contract = Contract::with('client')->find($id);
        $searchText = $request->input('searchText');

        $services = $contract->services()
            ->where(function ($query) use ($searchText) {
                $query->where('service_type', 'like', "%$searchText%")
                    ->orWhereHas('passenger', function ($query) use ($searchText) {
                        $query->where('passenger_name', 'like', "%$searchText%")
                            ->orWhere('passenger_last_name', 'like', "%$searchText%");
                    })
                    ->orWhere('origin_going', 'like', "%$searchText%")
                    ->orWhere('destination_going', 'like', "%$searchText%");
            })
            ->paginate(5);

        return view('contract.show', compact('contract', 'services', 'searchText'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contract = Contract::findOrFail($id);
        $currentAccount = $contract->currentAccount;
        //obtener cuotas de currentAcount
        $fees = $currentAccount->fees;

        foreach ($fees as $fee) {
            if ($fee->fee_state == "ADEUDADA") {
                return redirect()->route('contract.contractClient')->with('error', 'No se puede dar de baja el contrato. Tiene cuotas sin pagar.');
            }
        }

        $contract->contract_state = Contract::FINALIZADO;
        $contract->save();
        return redirect()->route('home')->with('success', 'Contrato dado de baja exitosamente.');
    }

    public function waitingApproval(Request $request)
    {
        $searchText = $request->input('searchText');

        $contracts = Contract::with('client')
            ->where('contract_state', Contract::ESPERANDO_APROBACION)
            ->where(function ($query) use ($searchText) {
                $query->where('contract_start_date', 'like', "%$searchText%")
                    ->orWhere('contract_end_date', 'like', "%$searchText%")
                    ->orWhere('contract_montly_fee', 'like', "%$searchText%")
                    ->orWhereHas('client', function ($query) use ($searchText) {
                        $query->whereHas('user', function ($query) use ($searchText) {
                            $query->where('name', 'like', "%$searchText%")
                                ->orWhere('lastName', 'like', "%$searchText%");
                        });
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('contract.waiting-approval', compact('contracts', 'searchText'));
    }


    public function enabled(Request $request)
    {
        $searchText = $request->input('searchText');

        $contracts = Contract::with('client')
            ->where('contract_state', Contract::HABILITADO)
            ->where(function ($query) use ($searchText) {
                $query->where('contract_start_date', 'like', "%$searchText%")
                    ->orWhere('contract_end_date', 'like', "%$searchText%")
                    ->orWhere('contract_montly_fee', 'like', "%$searchText%")
                    ->orWhere('contract_state', 'like', "%$searchText%")
                    ->orWhereHas('client', function ($query) use ($searchText) {
                        $query->whereHas('user', function ($query) use ($searchText) {
                            $query->where('name', 'like', "%$searchText%")
                                ->orWhere('lastName', 'like', "%$searchText%");
                        });
                    });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(5);

        return view('contract.enabled', compact('contracts', 'searchText'));
    }


    public function approve(string $id)
    {
        try {
            $contract = Contract::find($id);
            $contract->contract_state = Contract::HABILITADO;
            //poner los servicios en estado habilitado
            foreach ($contract->services as $service) {
                $service->service_state = Service::SIN_ASIGNAR;
                $service->save();
            }
            $contract->save();
            return redirect()->route('contract.waitingApproval')->with('success', 'Contrato aprobado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('contract.waitingApproval')->with('error', 'Error al aprobar el contrato');
        }
    }

    public function reject(string $id)
    {
        try {
            $contract = Contract::find($id);
            $contract->contract_state = Contract::RECHAZADO;
            foreach ($contract->services as $service) {
                $service->service_state = Service::PAUSADO;
                $service->save();
            }
            $contract->save();
            return redirect()->route('contract.waitingApproval')->with('success', 'Contrato rechazado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('contract.waitingApproval')->with('error', 'Error al rechazar el contrato');
        }
    }

    public function showContractClient()
    {
        try {
            $idUser = auth()->user()->id;

            // Encuentra al usuario
            $user = User::find($idUser);

            // Encuentra al cliente asociado al usuario
            $client = Client::find($user->userable_id);

            // Encuentra el contrato asociado al cliente, el mas reciente
            $contract = Contract::where('client_id', $client->id)->orderBy('created_at', 'desc')->first();
            $services = $contract->services()->paginate(5);
        } catch (\Throwable $th) {
            return view('contract.showContractClient')->with('error', 'Error al mostrar el contrato');
        }

        return view('contract.showContractClient', compact('contract', 'services'));
    }

    public function historialContract()
    {
        //obtener los contratos del cliente logueado
        $idUser = auth()->user()->id;
        $user = User::find($idUser);
        $client = Client::find($user->userable_id);
        $contracts = Contract::where('client_id', $client->id)->orderBy('created_at', 'desc')->paginate(5);
        return view('contract.historial', compact('contracts'));
    }
}
