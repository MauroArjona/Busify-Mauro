<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('contract_start_date');
            $table->dateTime('contract_end_date')->nullable();
            $table->double('contract_montly_fee', 15, 8);
            $table->string('contract_state')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->timestamps();
            
            // Constraints                                                     
            $table->foreign('client_id')->references('id')->on('clients')
                ->nullOnDelete()
                ->cascadeOnUpdate();                
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
