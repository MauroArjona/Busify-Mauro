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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_patent')->unique();
            $table->integer('unit_total_capacity')->default(15);
            $table->string('unit_model');
            $table->string('unit_brand');
            $table->unsignedInteger('unit_mileage');
            $table->text('unit_detail')->nullable();
            $table->string('unit_state')->nullable();            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
