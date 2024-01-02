<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.     * 
     */
    /*
        'travel_plan_name',
        'passenger_amount',
        'assistant_id',
        'unit_id',
        'driver_id',
        'supervisor_id'
    */
    public function up(): void
    {
        Schema::create('travel_plans', function (Blueprint $table) {
            $table->id();
            $table->string('travel_plan_name');
            $table->integer('passenger_amount');
            $table->unsignedBigInteger('assistant_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('supervisor_id');
            $table->string('travel_plan_state')->default('ACTIVO');
            $table->timestamps();

            // Constraints
            $table->foreign('assistant_id')->references('id')->on('assistants')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('unit_id')->references('id')->on('units')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('driver_id')->references('id')->on('drivers')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('supervisor_id')->references('id')->on('supervisors')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_plans');
    }
};
