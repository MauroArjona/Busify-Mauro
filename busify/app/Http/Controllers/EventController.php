<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Driver;
use Exception;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)

    {

        //obtener detalles del travel_report con id $id
        $travelReport = DB::table('travel_reports')
            ->where('travel_plan_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('event.create', compact('travelReport', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $idUser = auth()->user()->id;
        // Encuentra al usuario
        $user = User::find($idUser);
        // Encuentra al chofer asociado al usuario
        $driver = Driver::find($user->userable_id);

        //obtener todo el itinerario del chofer
        $travelPlan = DB::table('travel_plans')
            ->where('driver_id', $driver->id)
            ->first();

        //buscar el ultimo travel_report del chofer
        $travelReport = DB::table('travel_reports')
            ->where('driver_id', $driver->id)
            ->orderBy('created_at', 'desc')
            ->first();


        $event = Event::create([
            'travel_report_id' => $travelReport->id,
            'event_name' => $request->input('event_name'),
            'event_hour' => $request->input('event_hour'),
            'event_description' => $request->input('event_description'),
        ]);

        $event->save();

        $id = $travelPlan->id;

        $events = DB::table('events')
            ->where('travel_report_id', $travelReport->id)
            ->paginate(5);

        return view('event.create', compact('travelReport', 'events', 'id'))->with('success', 'Evento creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $events = DB::table('events')
            ->where('travel_report_id', $id)
            ->paginate(5);

        $travelReport = DB::table('travel_reports')
            ->where('id', $id)
            ->first();

        return view('event.show', compact('events', 'travelReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);

        return view('event.modify-event', compact('event'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $event = Event::findOrFail($id);

            $now = new \DateTime();
            $eventDate = new \DateTime($event->created_at);
            $interval = $now->diff($eventDate);
            $minutes = $interval->format('%i');

            if ($minutes > 10) {
                return redirect()->route('travel-report.edit', $event->travel_report_id)->with('error', 'No se puede modificar el evento porque ya pasaron 10 minutos desde que se creó.');
            }

            $event->update([
                'event_name' => $request->input('event_name'),
                'event_description' => $request->input('event_description'),
                'event_hour' => $request->input('event_hour'),
            ]);

            return redirect()->route('travel-report.edit', $event->travel_report_id)->with('success', 'Evento actualizado exitosamente');
        } catch (Exception $e) {
            return redirect()->route('travel-report.edit', $event->travel_report_id)->with('error', 'Error al actualizar el evento');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $event = Event::findOrFail($id);

            $now = new \DateTime();
            $eventDate = new \DateTime($event->created_at);
            $interval = $now->diff($eventDate);
            $minutes = $interval->format('%i');

            if ($minutes > 10) {
                return redirect()->route('travel-report.edit', $event->travel_report_id)->with('error', 'No se puede eliminar el evento porque ya pasaron 10 minutos desde que se creó.');
            }

            $event->delete();

            return redirect()->route('travel-report.edit', $event->travel_report_id)->with('success', 'Evento eliminado exitosamente');
        } catch (Exception $e) {
            return redirect()->route('travel-report.edit', $event->travel_report_id)->with('error', 'Error al eliminar el evento');
        }
    }
}
