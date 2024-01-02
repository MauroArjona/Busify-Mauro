<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory;
    
    public const PAUSADO = "PAUSADO";
    public const HABILITADO = "HABILITADO";
    public const FINALIZADO = "FINALIZADO";
    public const ESPERANDO_APROBACION = "ESPERANDO_APROBACION";
    public const RECHAZADO = "RECHAZADO";
    public const FINALIZADO_CON_DEUDA = "FINALIZADO_CON_DEUDA";

    protected $fillable = [        
        'contract_start_date',
        'contract_end_date',
        'contract_montly_fee',
        'contract_state',
        'client_id',
    ];
    // Relacion uno a uno (inversa) entre CuentaCorriente y Contrato
    public function currentAccount(): HasOne
    {        
        return $this->hasOne(CurrentAccount::class);
    }

    // Relacion uno a uno entre Contrato y Cliente
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    } 
    /**
     * Get all of the servicios for the Contrato
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }  
}
