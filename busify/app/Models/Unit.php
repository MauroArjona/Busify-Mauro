<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    public const DISPONIBLE = "DISPONIBLE";
    public const ASIGNADA = "ASIGNADA";
    public const DESAFECTADA = "DESAFECTADA";
    public const BAJA = "BAJA";

    protected $fillable = [
        'unit_patent',
        'unit_total_capacity',
        'unit_model',
        'unit_brand',
        'unit_mileage',
        'unit_detail',
        'unit_state'
    ];
    /**
     * Get all of the itinerarios for the Unidad
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function travelPlan(): HasMany
    {
        return $this->hasMany(TravelPlan::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(UnitHistory::class);
    }

}