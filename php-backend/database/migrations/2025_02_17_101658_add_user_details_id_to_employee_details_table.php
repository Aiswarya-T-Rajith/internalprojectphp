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
        Schema::table('employee_details', function (Blueprint $table) {
            $table->unsignedBigInteger('user_details_id')->after('emp_id');
            $table->foreign('user_details_id')->references('user_details_id')->on('users_table')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_details', function (Blueprint $table) {
            Schema::table('employee_details', function (Blueprint $table) {
                $table->dropForeign(['user_details_id']);
                $table->dropColumn('user_details_id');
            });
        });
    }
};
