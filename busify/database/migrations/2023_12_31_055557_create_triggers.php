<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('            
            CREATE OR REPLACE TRIGGER TR_units_AI
            AFTER INSERT
            ON units FOR EACH ROW
            BEGIN 
                
                INSERT INTO unit_histories (unit_id, unit_mileage, unit_detail, unit_state, unit_from_date, unit_to_date) 
                VALUES (NEW.id, NEW.unit_mileage, NEW.unit_detail, NEW.unit_state, (SELECT NOW()), NULL);
                
            END
        ');

        DB::unprepared('
            CREATE OR REPLACE TRIGGER TR_units_AU
            AFTER UPDATE
            ON units FOR EACH ROW
            BEGIN
                
                IF OLD.unit_state != NEW.unit_state THEN
                    
                    INSERT INTO unit_histories (unit_id, unit_mileage, unit_detail, unit_state, unit_from_date, unit_to_date) 
                    VALUES (NEW.id, NEW.unit_mileage, NEW.unit_detail, NEW.unit_state, (SELECT NOW()), NULL);
                        
                    UPDATE unit_histories
                    SET unit_to_date = (SELECT NOW())
                    WHERE (unit_id = NEW.id AND unit_state = OLD.unit_state AND unit_to_date IS NULL);		
                    
                END IF;	
                
            END
        ');
        DB::unprepared("
            CREATE OR REPLACE TRIGGER TR_fees_BU
            BEFORE UPDATE ON fees FOR EACH ROW 
            BEGIN 
                -- Cuando se actualiza el puntaje?             
                CASE	
                    -- Cuando vence una cuota (fee)
                    WHEN (OLD.fee_state = 'ADEUDADA' AND NEW.fee_state = 'EN_MORA') THEN	
                        -- Actualizo puntaje
                        CALL SP_update_score(NEW.current_account_id, 'DECREMENTAR'); 
            
                    -- Cuando se paga una cuota (fee)
                    WHEN (OLD.fee_state = 'ADEUDADA' AND NEW.fee_state = 'PAGA') THEN
                        -- Actualizo puntaje
                        CALL SP_update_score(NEW.current_account_id, 'INCREMENTAR');
                        
                    ELSE BEGIN END;
                END CASE;
            END
        ");      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS TR_units_AI');
        DB::unprepared('DROP TRIGGER IF EXISTS TR_units_AU');
        DB::unprepared('DROP TRIGGER IF EXISTS TR_fees_BU');
        
    }
};
