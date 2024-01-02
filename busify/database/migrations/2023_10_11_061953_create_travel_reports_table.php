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
        'travel_report_date',
        'travel_report_state',
        'travel_plan_id'
    */
    public function up(): void
    {
        Schema::create('travel_reports', function (Blueprint $table) {
            $table->id();
            $table->dateTime('travel_report_date');   
            $table->text('description');         
            $table->unsignedBigInteger('driver_id')->nullable();       
            $table->unsignedBigInteger('travel_plan_id');   
            $table->unsignedFloat('mileage_start');
            $table->unsignedFloat('mileage_end')->nullable()->default(null);       
            $table->timestamps();

            // Constraints           
            $table->foreign('travel_plan_id')->references('id')->on('travel_plans')
                ->noActionOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('driver_id')->references('id')->on('drivers')
                ->noActionOnDelete()
                ->cascadeOnUpdate();        
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_reports');
    }
};
