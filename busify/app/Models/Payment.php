<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_date',
        'payment_amount',
        'fee_id'
    ];

    // Relación uno a uno (inversa) entre Cuota y Pago
    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }
}
