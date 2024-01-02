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
        'event_name',
        'event_description',
        'event_hour',
        'travel_report_id'
    */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('event_description');
            $table->time('event_hour');
            $table->unsignedBigInteger('travel_report_id');
            $table->timestamps();
            
            // Constraints
            $table->foreign('travel_report_id')->references('id')->on('travel_reports')
            ->onDelete('cascade')
            ->onUpdate('cascade'); 
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
