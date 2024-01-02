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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->double('fee_amount', 15, 8)->default(0.0);
            $table->dateTime('fee_expiration_date');
            $table->string('fee_state')->nullable();     
            $table->unsignedBigInteger('current_account_id')->nullable();                        
            $table->timestamp(column: 'created_at')->useCurrent();
            $table->timestamp(column: 'updated_at')->useCurrent();

            // Constraints                 
            $table->foreign('current_account_id')->references('id')->on('current_accounts')
                ->onDelete('set null')
                ->onUpdate('cascade');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
