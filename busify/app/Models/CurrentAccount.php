<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CurrentAccount extends Model
{
    use HasFactory;

    public const HABILITADA = "HABILITADA";
    public const DESHABILITADA = "DESHABILITADA";   // Analizar si tiene sentido
    public const SUSPENDIDA = "SUSPENDIDA";    
    public const CANCELADA = "CANCELADA";

    protected $fillable = [
        'current_account_score',
        'current_account_state',
        'contract_id',
        'six_month_counter',
        'wildcard_counter'
    ];   

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }
}
