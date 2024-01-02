<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_description',
        'event_hour',
        'travel_report_id'
    ];

    public function travelReports(): HasMany
    {
        return $this->hasMany(TravelReport::class);
    }
}
