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
            $table->dropColumn(['document_name','document_file_path']);

            $table->json('documents_section')->after('emp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_documents', function (Blueprint $table) {
             $table->string('document_name')->nullable();
             $table->string('document_file_path')->nullable();
 
             $table->dropColumn('documents_section');
        });
    }
};
