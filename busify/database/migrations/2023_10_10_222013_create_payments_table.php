<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->datetime('payment_date');
            $table->double('payment_amount', 15, 8, true);
            $table->unsignedBigInteger('fee_id')->nullable();
            $table->timestamps();
            
            // Constraints
            $table->foreign('fee_id')->references('id')->on('fees')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
