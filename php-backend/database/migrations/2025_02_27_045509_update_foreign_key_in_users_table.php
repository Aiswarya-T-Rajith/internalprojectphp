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
        Schema::table('users_table', function (Blueprint $table) {
           // Drop the existing foreign key constraint
           $table->dropForeign(['user_id']);
            
           // Add a new foreign key referencing the 'users' table
           $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_table', function (Blueprint $table) {
            Schema::table('users_table', function (Blueprint $table) {
                // Drop the new foreign key constraint
                $table->dropForeign(['user_id']);
                
                // Restore the previous foreign key reference to 'login_details'
                $table->foreign('user_id')->references('user_id')->on('login_details')->onDelete('cascade');
            });
        });
    }
};
