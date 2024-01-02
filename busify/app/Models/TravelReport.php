<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelReport extends Model
{   
    use HasFactory;

    protected $fillable = [
        'travel_report_date',
        'driver_id',
        'travel_report_state',
        'travel_plan_id',
        'description',
        'mileage_start',
        'mileage_end'
    ];
   
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
   
    public function travelPlan(): BelongsTo
    {
        return $this->belongsTo(TravelPlan::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
