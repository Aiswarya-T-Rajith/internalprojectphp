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
        Schema::table('users', function (Blueprint $table) {
            // Check if 'name' column exists before dropping
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }

            // Check if 'id' column exists before renaming
            if (Schema::hasColumn('users', 'id')) {
                $table->renameColumn('id', 'user_id'); // Match `login_details`
            }

            // Add 'role' column only if it does not exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['employee', 'admin', 'superadmin'])->default('employee');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add 'name' column
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable();
            }

            // Rename 'user_id' back to 'id' if needed
            if (Schema::hasColumn('users', 'user_id')) {
                $table->renameColumn('user_id', 'id');
            }

            // Drop 'role' column if it exists
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
