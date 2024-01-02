<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Driver extends Model
{
    use HasFactory;

    public const DISPONIBLE = "DISPONIBLE";
    public const ASIGNADO = "ASIGNADO";
    public const DESCANSO = "DESCANSO";
    public const BAJA = "BAJA";
    
    protected $fillable = [   
        'driver_cuil',
        'driver_start_date',             
        'driver_state'
    ];

    public function user() : MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }    
   
    // Relacion uno a uno entre Contrato y Cliente
    public function travelPlans(): HasMany
    {
        return $this->hasMany(TravelPlan::class);
    }

    public function travelReports(): HasMany
    {
        return $this->hasMany(TravelReport::class);
    }   
}



