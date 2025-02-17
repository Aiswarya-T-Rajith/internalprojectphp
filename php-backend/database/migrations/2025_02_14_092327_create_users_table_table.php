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
        Schema::create('users_table', function (Blueprint $table) {
            $table->id('user_details_id');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed']);
            $table->string('nationality');
            $table->string('phone_number');
            $table->string('permanent_address');
            $table->string('current_address');
            $table->enum('employee_status', ['On-boarding', 'Working', 'Left']);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('login_details')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_table');
    }
};
