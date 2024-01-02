<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Fee;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:payment.index');
    }

    /**
     * Display a listing of the resource.
     */



     public function index(Request $request)
    {
        try {
            $idUser = auth()->user()->id;

            $user = User::find($idUser);

            $client = Client::find($user->userable_id);

            $searchText = $request->get('searchText');
            
            $paymentsQuery = Client::with('contracts.currentAccount.fees.payment')
                ->where('id', $client->id);

            if ($searchText) {
                $paymentsQuery->whereHas('contracts.currentAccount.fees.payment', function ($query) use ($searchText) {
                    $query->where('payment_amount', 'like', '%' . $searchText . '%')
                        ->orWhere('payment_date', 'like', '%' . $searchText . '%');
                })->orderBy('created_at', 'asc'); 
            } else {
                $paymentsQuery->orderBy('created_at', 'desc');
            }
            
            $payments = $paymentsQuery->paginate(5);

            return view('payment.index', compact('payments', 'searchText'));
        } catch (\Throwable $th) {
            return redirect()->route('payment.index')->with('error', 'No se encontraron pagos.');
        }
    }

     

     
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $selectedFeeIds = $request->input('selected_fees', []);
            $fees = Fee::findMany($selectedFeeIds);
            $total = $fees->sum('fee_amount');
            if ($fees->count() == 0) {
                return redirect()->route('fee.index')->with('error', 'No se seleccionó ninguna cuota.');
            }
            if ($total == 0) {
                return redirect()->route('fee.index')->with('error', 'No se puede realizar el pago de una cuota de $0.');
            }
        } catch (\Throwable $th) {
            return redirect()->route('fee.index')->with('error', 'Error al procesar el pago.');
        }
        return view('payment.payment-page', compact('fees', 'total'));
        return $fees;
        return $selectedFeeIds;
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
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
