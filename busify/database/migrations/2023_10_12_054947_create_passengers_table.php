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
        'passenger_dni',
        'passenger_name',
        'passenger_last_name',
        'blood_type',
        'disability',
        'service_id'
    */
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('passenger_dni')->unique();
            $table->string('passenger_name');
            $table->string('passenger_last_name');
            $table->string('blood_type'); // Analizar si puede ser un enum
            $table->string('disability')->nullable();              
            $table->unsignedBigInteger('service_id')->unique();
            $table->timestamps();

            // Constraints            
            $table->foreign('service_id')->references('id')->on('services')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
