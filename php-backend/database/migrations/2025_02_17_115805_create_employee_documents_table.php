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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id("documents_id");
            $table->string("document_type");
            $table->string("document_name");
            $table->string("document_file_path");

            //Foreign key referencing employee_details table
            $table->unsignedBigInteger("emp_id");
            $table->foreign("emp_id")->references("emp_id")->on("employee_details")->onDelete("cascade");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
