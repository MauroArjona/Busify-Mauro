<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_dni',
        'passenger_name',
        'passenger_last_name',
        'blood_type',
        'disability',
        'service_id'
    ];
    /**
     * Get the servicio that owns the Pasajero
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(): BelongsTo
    {   
        return $this->belongsTo(Service::class);
    }
}
