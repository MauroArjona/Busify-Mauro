<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelReport;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Driver;
use Exception;
use Carbon\Carbon;

class TravelReportController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('searchText');

        $travel_reports = TravelReport::where('travel_report_date', 'like', '%' . $searchQuery . '%')
            ->orWhere('description', 'like', '%' . $searchQuery . '%')
            ->orderBy('travel_report_date', 'desc')
            ->paginate(5);

        return view('travel-report.index', compact('travel_reports'));
    }

    public function create()
    {
        $idUser = auth()->user()->id;

        // Encuentra al usuario
        $user = User::find($idUser);

        // Encuentra al chofer asociado al usuario
        $driver = Driver::find($user->userable_id);
        //obtener id del itinerario del chofer
        $idTravel = DB::table('travel_plans')
            ->where('driver_id', $driver->id)
            ->value('id');
        return view('travel-report.create', compact('driver', 'idTravel'));
    }
    public function store(Request $request)
    {
        $idUser = auth()->user()->id;
        // Encuentra al usuario
        $user = User::find($idUser);
        //description es un textarea
        // Encuentra al chofer asociado al usuario
        $driver = Driver::find($user->userable_id);
        try {
            $travelPlanId = DB::table('travel_plans')
                ->where('driver_id', $driver->id)
                ->value('id');
            $travelReport = TravelReport::create([
                'travel_plan_id' => $travelPlanId,
                'description' => $request->input('description'),
                'driver_id' => $driver->id,
                'mileage_start' => $request->input('mileage_start'),
                'mileage_end' => $request->input('mileage_end'),
                'travel_report_date' => date('Y-m-d H:i:s')
            ]);
            $travelReport->save(); //cambiar por eventController.create, mandarle el id del itinerario
            return redirect()->route('event.create', $travelPlanId)->with('success', 'Reporte de viaje creado exitosamente');
        } catch (Exception $e) {
            return redirect()->route('travel-report.driverTravelReport')->with('error', 'No se pudo crear el reporte de viaje ' . $e->getMessage());
        }
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
        $events = DB::table('events')
            ->where('travel_report_id', $id)
            ->paginate(5);

        $travelReport = DB::table('travel_reports')
            ->where('id', $id)
            ->first();

        return view('travel-report.modify-description', compact('events', 'travelReport'));
    }
    public function update(Request $request, string $id)
    {
        try {
            $travelReport = DB::table('travel_reports')->find($id);

            $now = new \DateTime();
            $travelReportDate = new \DateTime($travelReport->created_at);
            $interval = $now->diff($travelReportDate);
            $minutes = $interval->format('%i');

            if ($minutes > 10) {
                return redirect()->route('travel-report.edit', $travelReport->id)->with('errorDescription', 'No se puede modificar el parte de viaje porque ya pasaron 10 minutos desde que se creó.');
            }


            if ($travelReport) {
                DB::table('travel_reports')
                    ->where('id', $id)
                    ->update(['description' => $request->input('description')]);

                return redirect()->back()->with('successDescription', 'Descripción actualizada exitosamente');
            }

            return redirect()->back()->with('error', 'No se pudo encontrar el parte de viaje');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la descripción');
        }
    }


    public function driverTravelReport(Request $request)
    {
        $idUser = auth()->user()->id;

        // Encuentra al usuario
        $user = User::find($idUser);

        // Encuentra al chofer asociado al usuario
        $driver = Driver::find($user->userable_id);

        $searchQuery = $request->input('searchText');

        $travel_reports = TravelReport::where('driver_id', $driver->id)
            ->where(function ($query) use ($searchQuery) {
                $query->where('travel_report_date', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            })
            //mas reciente primero
            ->orderBy('travel_report_date', 'desc')
            ->paginate(5);

        return view('travel-report.driver', compact('travel_reports'));
    }

    public function destroy(string $id)
    {
        //tener en cuenta los 10 minutos, si ya pasaron no se puede eliminar
        try {
            $travelReport = TravelReport::findOrFail($id);

            $now = new \DateTime();
            $travelReportDate = new \DateTime($travelReport->created_at);
            $interval = $now->diff($travelReportDate);
            $minutes = $interval->format('%i');

            if ($minutes > 10) {
                return redirect()->route('travel-report.driverTravelReport')->with('error', 'No se puede eliminar el parte de viaje porque ya pasaron 10 minutos desde que se creó.');
            }

            $travelReport->delete();

            return redirect()->route('travel-report.driverTravelReport')->with('success', 'Parte de viaje eliminado exitosamente');
        } catch (Exception $e) {
            return redirect()->route('travel-report.driverTravelReport')->with('error', 'No se pudo eliminar el parte de viaje');
        }
    }
}
