<?php
// database/migrations/2026_06_25_000000_create_enquiries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('interested_course')->nullable();
            $table->date('inquiry_date')->nullable();
            $table->string('source')->nullable()->default('Website Contact Form');
            $table->enum('status', ['new', 'in_progress', 'resolved', 'closed'])->default('new');
            $table->text('message')->nullable();
            $table->string('qualification')->nullable();
            $table->string('city')->nullable();
            $table->string('preferred_time')->nullable(); // Morning, Afternoon, Evening
            $table->text('notes')->nullable(); // Admin notes
            $table->date('follow_up_date')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('email');
            $table->index('phone_number');
            $table->index('status');
            $table->index('inquiry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};