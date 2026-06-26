<?php
// database/migrations/2026_06_24_000000_create_certificates_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->string('certificate_no')->unique();
            $table->date('issue_date');
            $table->text('remarks')->nullable();
            $table->string('title')->default('Certificate of Completion');
            $table->enum('status', ['issued', 'verified', 'pending'])->default('issued');
            $table->string('student_name');
            $table->string('student_id');
            $table->string('course_name');
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes
            
            // Indexes for better performance
            $table->index('certificate_no');
            $table->index('status');
            $table->index('issue_date');
            $table->index('student_name');
            $table->index('student_id');
            $table->index('course_name');
            $table->index(['status', 'issue_date']); // Composite index for common queries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};