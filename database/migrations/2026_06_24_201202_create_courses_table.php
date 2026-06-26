<?php
// database/migrations/2026_01_01_000001_create_courses_table.php

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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('name');
            $table->string('duration');
            $table->decimal('original_fee', 12, 2);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');
            $table->json('instructor_ids')->nullable(); // Store instructor IDs as JSON
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};