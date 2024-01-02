<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',       
        'unit_mileage',
        'unit_detail',
        'unit_state',        
        'unit_from_date',
        'unit_to_date'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
