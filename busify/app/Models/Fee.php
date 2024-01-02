<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fee extends Model
{
    use HasFactory;

    public const PAGA = "PAGA";
    public const ADEUDADA = "ADEUDADA";
    public const EN_MORA = "EN_MORA";

    protected $fillable = [
        'fee_amount',
        'fee_expiration_date',
        'fee_state',
        'current_account_id'
    ];    
    // Relación uno a uno entre Cuota y Pago
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // Realación uno a muchos (inversa) entre Cuota y Cuenta Corriente
    public function currentAccount(): BelongsTo
    {
        return $this->belongsTo(CurrentAccount::class);
    }
}