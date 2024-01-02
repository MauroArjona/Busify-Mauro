<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $searchText = trim($request->input('searchText'));

        $clients = Client::with('user')
            ->where(function ($query) use ($searchText) {
                $query->where('client_cuil', 'like', "%$searchText%")
                    ->orWhereHas('user', function ($query) use ($searchText) {
                        $query->where('name', 'like', "%$searchText%")
                            ->orWhere('lastName', 'like', "%$searchText%")
                            ->orWhere('email', 'like', "%$searchText%");
                    });
            })
            ->paginate(5);

        return view('client.index', compact('clients', 'searchText'));
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

        $client = Client::with('user')->findOrFail($id);


        return view('client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function desactivate(string $idCliente)
    {
        $client = Client::findOrFail($idCliente);
        if ($client->contracts()->whereIn('contract_state', ['HABILITADO', 'ESPERANDO_APROBACION', 'PAUSADO'])->count() > 0) {
            return redirect()->route('home')->with('error', 'No se puede eliminar el cliente porque tiene contratos activos');
        } else {
            $passwordRandom = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            $client->user()->update([
                'password' => Hash::make($passwordRandom),
            ]);
            auth()->logout();     
            return redirect()->route('home')->with('success', 'Cliente eliminado correctamente'); 
        }         
    }
}
