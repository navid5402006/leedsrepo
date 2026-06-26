<?php
// database/migrations/2026_06_26_000001_create_talent_test_attempts_table.php

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
        Schema::create('talent_test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')
                  ->constrained('talent_test_students')
                  ->onDelete('cascade');
            $table->string('roll_number')->unique();
            $table->date('test_date');
            $table->integer('obtained_marks')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->enum('status', ['pending', 'pass', 'fail'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('roll_number');
            $table->index('status');
            $table->index('test_date');
            $table->index(['candidate_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_test_attempts');
    }
};