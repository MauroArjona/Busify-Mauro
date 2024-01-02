<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Supervisor extends Model
{
    use HasFactory;

    public const OPERATIVO = 'OPERTATIVO';
    public const DESAFECTADO = 'DESAFECTADO';

    protected $fillable = [   
        'supervisor_cuil',
        'supervisor_state'
    ];
    
    public function travelPlan(): HasMany
    {
        return $this->hasMany(TravelPlan::class);
    }    
    
    public function user() : MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
       
}