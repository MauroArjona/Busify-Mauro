<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /*
        'distance',
        'origin_going',
        'destination_going',
        'hour_pickup_going',
        'hour_arrival_going',
        'destination_return',
        'hour_arrival_return',
        'service_state',
        'service_type',
        'contract_id',
        'route_plan_id'  
    */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedFloat('distance');
            $table->string('origin_going');
            $table->string('destination_going');
            $table->time('hour_pickup_going');
            $table->time('hour_arrival_going');
            $table->string('destination_return')->nullable();
            $table->time('hour_arrival_return')->nullable();            
            $table->string('service_state')->nullable(); // Consultar si tiene sentido que sea nullable
            $table->string('service_type')->nullable(); // Consultar si tiene sentido que sea nullable 
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('travel_plan_id')->nullable();
            $table->timestamps();
            
            // Constraints            
            $table->foreign('contract_id')->references('id')->on('contracts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('travel_plan_id')->references('id')->on('travel_plans')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
