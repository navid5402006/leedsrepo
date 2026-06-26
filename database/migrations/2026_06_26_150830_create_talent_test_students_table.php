<?php
// database/migrations/2026_06_26_000000_create_talent_test_students_table.php

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
        Schema::create('talent_test_students', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('father_name');
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('registration_date');
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('candidate_name');
            $table->index('contact_number');
            $table->index('registration_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_test_students');
    }
};