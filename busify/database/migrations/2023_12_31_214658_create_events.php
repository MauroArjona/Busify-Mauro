<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE OR REPLACE EVENT EV_monthly_closing
            ON SCHEDULE EVERY 1 MINUTE
            STARTS '2023-11-01 00:00:00.000'
            ON COMPLETION PRESERVE
            ENABLE
            DO BEGIN 
            -- Analizo las fecha de vencimiento de las cuotas
            CALL SP_check_fees_expiration_date();	  
            -- Analizo las fecha de vencimiento de los contratos
            CALL SP_check_contracts_expiration_date();
            -- Genero las cuotas
            CALL SP_generate_fees();
        END
        ");
    }    
    
    public function down(): void
    {        
        DB::unprepared("DROP EVENT IF EXISTS EV_monthly_closing");       
    }    
};
