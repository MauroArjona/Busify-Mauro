<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelPlan extends Model
{
    use HasFactory;

    public const ARCHIVADO = "ARCHIVADO";
    public const ACTIVO = "ACTIVO";

    protected $fillable = [
        'travel_plan_name',
        'passenger_amount',
        'assistant_id',
        'unit_id',
        'driver_id',
        'supervisor_id',
        'travel_plan_state'
    ];

    /**
     * Get the unidad that owns the Itinerario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);        
    }
    /**
     * Get the asistente that owns the Itinerario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assistant(): BelongsTo
    {   
        return $this->belongsTo(Assistant::class);
    }
    /**
     * Get the chofer that owns the Itinerario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
    /**
     * Get the supervisor that owns the Itinerario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class);
    }
    /**
     * Get all of the partes for the Itinerario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function travelReports(): HasMany
    {
        return $this->hasMany(TravelReport::class);
    }
    /**
     * Get all of the servicios for the Itinerario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
