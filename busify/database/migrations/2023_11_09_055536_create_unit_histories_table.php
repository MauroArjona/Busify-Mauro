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
        Schema::create('unit_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('unit_mileage');
            $table->text('unit_detail')->nullable();
            $table->string('unit_state');        
            $table->dateTime('unit_from_date');
            $table->dateTime('unit_to_date')->nullable();
            
            // Constraints
            $table->foreign('unit_id')->references('id')->on('units')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_histories');
    }
};

