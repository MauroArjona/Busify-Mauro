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
        Schema::create('current_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('current_account_score');
            $table->string('current_account_state')->nullable();
            $table->unsignedInteger('six_month_counter');
            $table->unsignedInteger('wildcard_counter');
            $table->unsignedBigInteger('contract_id')->nullable()->unique();  
            $table->timestamps();
            
            // Constraints                 
            $table->foreign('contract_id')->references('id')->on('contracts')
                ->onDelete('set null')
                ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_accounts');
    }
};
