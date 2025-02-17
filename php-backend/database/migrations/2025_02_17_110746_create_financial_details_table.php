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
        Schema::create('financial_details', function (Blueprint $table) {
            $table->id('finance_id');
            $table->string('bank_account_number'); 
            $table->string('ifsc_code'); 
            $table->string('pan_card_number');
            $table->string('UAN');
            
            // Foreign key referencing employee_details table
            $table->unsignedBigInteger('emp_id');
            $table->foreign('emp_id')->references('emp_id')->on('employee_details')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_details');
    }
};
