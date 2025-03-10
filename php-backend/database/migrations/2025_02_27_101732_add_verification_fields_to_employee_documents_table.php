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
        Schema::table('employee_documents', function (Blueprint $table) {
            $table->enum('admin_verification_status', ['pending', 'approved', 'rejected'])->default('pending')->after('emp_id');
            $table->text('admin_verification_comments')->nullable()->after('admin_verification_status');
            $table->timestamp('admin_verified_at')->nullable()->after('admin_verification_comments');

            $table->enum('superadmin_verification_status', ['pending', 'approved', 'rejected'])->default('pending')->after('admin_verified_at');
            $table->text('superadmin_verification_comments')->nullable()->after('superadmin_verification_status');
            $table->timestamp('superadmin_verified_at')->nullable()->after('superadmin_verification_comments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_documents', function (Blueprint $table) {
            $table->dropColumn([
                'admin_verification_status',
                'admin_verification_comments',
                'admin_verified_at',
                'superadmin_verification_status',
                'superadmin_verification_comments',
                'superadmin_verified_at'
            ]);
        });
    }
};
