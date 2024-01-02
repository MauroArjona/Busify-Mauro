<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Assistant extends Model
{
    use HasFactory;

    public const DISPONIBLE = "DISPONIBLE";
    public const ASIGNADO = "ASIGNADO";

    protected $fillable = [       
        'assistant_name',
        'assistant_last_name',
        'assistant_cuil',
        'assistant_state'
    ];
    /**
     * Get all of the itinerarios for the Asistente
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

     public function assistants()
{
    return $this->belongsTo(User::class, 'assistant_id');
}


    public function travelPlans(): HasMany
    {
        return $this->hasMany(TravelPlan::class);
    }
}
