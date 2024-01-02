<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {        
        DB::unprepared("  
            CREATE OR REPLACE PROCEDURE SP_update_score(IN _current_account_id INT, IN _op VARCHAR(11))
            BEGIN		
                DECLARE _state VARCHAR(30);
                DECLARE _score INT;	 
               	DECLARE _score_old INT;
                DECLARE _wildcard INT;
                DECLARE _sm_counter INT;
               
                SELECT current_account_state, current_account_score, wildcard_counter, six_month_counter
                INTO _state, _score, _wildcard, _sm_counter
                FROM current_accounts
                WHERE id = _current_account_id;
               	
               	-- Guardo el valor inicial del puntaje
               	SET _score_old = _score; 
               
                IF _op = 'INCREMENTAR' THEN	
                    CASE
                        -- Si el estado de la cuenta es HABILITADA y el puntaje está por debajo de 80, entonces
                        WHEN (_state = 'HABILITADA' AND _score < 80) THEN					
                            -- sumo 5 al puntaje.
                            SET _score = _score + 5;
                        
                        -- Si el estado de la cuenta es HABILITADA, el puntaje está por encima de 80 y
                        -- el contador de buen cliente es menor que seis (1 por mes meses).
                        WHEN (_state = 'HABILITADA' AND _score >= 80 AND _sm_counter < 6) THEN
                            -- sumo 1 al contador de seis meses como buen cliente.
                            SET _sm_counter = _sm_counter + 1;		        	   
                        
                        -- Si el estado de la cuenta es HABILITADA, el puntaje está por encima de 80 y
                        -- el contador de buen cliente es seis.   
                        WHEN (_state = 'HABILITADA' AND _score >= 80 AND _sm_counter = 6) THEN
                            -- sumo 5 al puntaje y reseteo el contador de seis meses como buen cliente.
                            SET _score = _score + 5;
                            SET _sm_counter = 0;                                                            
                        ELSE BEGIN END;
                    END CASE;	
                    -- Si después de modificarse puntaje, quedó por ansima de cien, lo seteo en cien.
                    IF _score >= 100 THEN
                        SET _score = 100;
                    END IF;
                END IF;
                
                IF _op = 'DECREMENTAR' THEN	    	
                    CASE
                        -- Si se gastaron los tres comodines, entonces
                        WHEN _wildcard >= 3 THEN
                            -- resto 5 al puntaje
                            SET _score = _score - 5;            	          	
                        -- Si NO se gastaron los comodines, entonces
                        WHEN _wildcard < 3 THEN
                            -- sumo un comodin
                            SET _wildcard = _wildcard + 1;    
                        ELSE BEGIN END;
                    END CASE;
                    -- si el puntaje quedó por debajo de cero, lo seteo en cero.
                    IF _score < 0 THEN 
                        SET _score = 0;
                    END IF;  
                END IF;
            
               	-- Si el puntaje anterior es mayor que 50 y el nuevo es menor igual que 50,
		        -- entonces
		        IF (_score_old > 50 AND _score <= 50) THEN
		        	-- Suspendo la cuenta
		            SET _state = 'SUSPENDIDA';
		        END IF;		           
		         
		        -- Si el puntaje anterior es menor que 80 y el nuevo es mayor igual que 80,
		        -- entonces
		        IF (_score_old < 80 AND _score >= 80) THEN                        
		                	-- la cuenta entró por primera vez en +80 puntos,
		                    -- comienza a contar los +5 puntos cada 6 meses
		                    -- por lo tanto reseteo el contador respectivo.
		                    SET _sm_counter = 0;		          
               	END IF;
               
                -- Actualizo la cuenta acorde a las variables calculadas.
                UPDATE current_accounts 
                SET current_account_state = _state, current_account_score = _score, wildcard_counter = _wildcard, six_month_counter = _sm_counter
                WHERE id = _current_account_id;     	
            
            END
        ");  
        
        DB::unprepared("   
            CREATE OR REPLACE PROCEDURE SP_check_fees_expiration_date()
            BEGIN 
                DECLARE f_id INT;
                DECLARE cc_id INT;
                DECLARE _fin INT DEFAULT 0;
                                        
                -- Selecciono todas las cuotas vencidas y las asigno a un cursor
                DECLARE cur CURSOR FOR			
                    SELECT id, current_account_id FROM fees 
                    WHERE (fee_state  = 'ADEUDADA' AND fee_expiration_date < NOW());		
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET _fin = 1;
                                                    
                OPEN cur;
                    -- Recorro cada una de las cuotas vencidas
                    loop_fees: LOOP                        
                        -- Asigno los valores de la cuota vencida a las variables f_id y cc_id
                        FETCH cur INTO f_id, cc_id;	                        
                        IF _fin THEN
                            LEAVE loop_fees;
                        END IF;
                        -- Actualizo el estado de la cuota vencida
                        UPDATE fees SET fee_state = 'EN_MORA' WHERE id = f_id;  
                    
                    END LOOP;
                CLOSE cur;	            
            END
        "); 
        
        DB::unprepared("
            CREATE OR REPLACE PROCEDURE SP_check_contracts_expiration_date()
            BEGIN
                DECLARE c_id INT;
                DECLARE s_id INT;                         	
                DECLARE _finC INT DEFAULT 0;
                DECLARE _finS INT DEFAULT 0;    
                DECLARE _due_fees INT;
                
                -- Selecciono todos los contratos vencidos y los asigno a un cursor
                DECLARE _curC CURSOR FOR			
                    SELECT c.id  
                    FROM contracts c 
                    WHERE c.contract_end_date < NOW();               	
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET _finC = 1;   	
                
                -- Recorro los contratos vencidos.
                OPEN _curC;
                    loop_contracts : LOOP		    
                        FETCH _curC INTO c_id;                             
                        IF _finC THEN
                            LEAVE loop_contracts;
                        END IF;						
                        
                        inner_block : BEGIN
                            -- Selecciono los servicios de un contrato
                            DECLARE _curS CURSOR FOR			
                                SELECT s.id  
                                FROM services s 
                                WHERE s.contract_id = c_id;           	
                            DECLARE CONTINUE HANDLER FOR NOT FOUND SET _finS = 1; 
                            
                            -- Recorro los servicios de un contrato
                            OPEN _curS;
                                loop_services : LOOP
                                    FETCH _curS INTO s_id;
                                    IF _finS THEN
                                        LEAVE loop_services;
                                    END IF;					
                                    -- Desvinculo un servicio de su itinerario.
                                    UPDATE services SET travel_plan_id = NULL WHERE id = s_id;      
                                END LOOP loop_services;
                            CLOSE _curS;	
                        
                        END inner_block;
                    
                        -- Asigno la cantidad de cuotas sin pagar o en mora que tiene el contrato
                        -- a la variable _due_fees
                        SELECT COUNT(f.fee_state) INTO _due_fees FROM fees f WHERE f.current_account_id IN (
                            SELECT id FROM current_accounts ca WHERE ca.contract_id = c_id)
                        GROUP BY f.fee_state
                        HAVING f.fee_state = 'ADEUDADA' OR f.fee_state = 'EN_MORA';
                    
                        -- Si no hay cuotas con deuda o en mora, entonces	
                        IF _due_fees = 0 THEN
                            -- actualizo el estado del contrato al estado FINALIZADO
                            UPDATE contracts c SET c.contract_state = 'FINALIZADO' WHERE c.id = c_id;
                        -- caso contrario
                        ELSE
                            -- actualizo el estado del contrato al estado FINALIZADO_CON_DEUDAS
                            UPDATE contracts c SET c.contract_state = 'FINALIZADO_CON_DEUDA' WHERE c.id = c_id;
                        END IF;	
                        
                    END LOOP loop_contracts;
                CLOSE _curC;                  
            END
        ");
        DB::unprepared("
        CREATE OR REPLACE PROCEDURE SP_generate_fees()
        BEGIN
                
            DECLARE _id INT UNSIGNED;
            DECLARE _montly_fee VARCHAR(30);
            DECLARE _id_cc INT UNSIGNED;
            DECLARE _fin BOOLEAN DEFAULT FALSE;            
            -- Busco todos los contratos con estado HABILITADO y 
            -- los asigno a un cursor para recorrelos
            DECLARE _cursor CURSOR FOR			
            SELECT id, contract_montly_fee FROM contracts  
            WHERE contract_state = 'HABILITADO';	
            DECLARE CONTINUE HANDLER FOR NOT FOUND SET _fin = TRUE;
        
            OPEN _cursor;			
            
            -- Utilizo el cursor para recorrer cada uno de los contratos seleccionados previamente
            loop_contracts: LOOP                        
                -- Asigno las variables id y contract_montly_fee del contrato actual
                -- a las variables locales _id y _montly_fee
                FETCH _cursor INTO _id, _montly_fee;	
                -- Si ya no existen más elementos finalizamos el ciclo.
                IF _fin THEN
                    LEAVE loop_contracts;
                END IF;
                -- Busco el id de la cuenta corriente asociada al contrato actual
                SELECT id INTO _id_cc FROM current_accounts
                WHERE contract_id = _id;       
        
                -- Insertar una nueva cuota                
                INSERT INTO fees (fee_amount, fee_expiration_date, fee_state, current_account_id)
                VALUES (_montly_fee, SUBTIME((NOW() + INTERVAL 1 MONTH), '0:01:0.000000'), 'ADEUDADA', _id_cc);	       	
                
            END LOOP;
        
            CLOSE _cursor;	
            
        END
    ");
    }

    public function down(): void
    { 
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_update_score");
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_check_fees_expiration_date");
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_check_contracts_expiration_date");
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_generate_fees");
    }
};
