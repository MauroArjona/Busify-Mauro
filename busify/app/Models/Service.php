<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
    use HasFactory;

    public const SIN_ASIGNAR = "SIN_ASIGNAR";
    public const ASIGNADO = "ASIGNADO";
    public const PAUSADO = "PAUSADO";  
    
    public const COMPLETO = "App\Models\CompleteSrv";
    public const SEMICOMPLETO = "App\Models\SemicompleteSrv";
       
    protected $fillable = [
        'distance',
        'origin_going',
        'destination_going',
        'hour_pickup_going',
        'hour_arrival_going',
        'destination_return',
        'hour_arrival_return',
        'service_state',
        'service_type',
        'contract_id',
        'travel_plan_id'        
    ];

    public function passenger(): HasOne
    {
        return $this->hasOne(Passenger::class);
    }    

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function travelPlan(): BelongsTo
    {
        return $this->belongsTo(TravelPlan::class);
    }
}
