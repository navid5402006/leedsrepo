<?php
// database/migrations/2026_01_01_000006_create_student_cards_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('card_no')->unique();
            $table->string('reg_no')->unique();
            $table->date('issue_date');
            $table->enum('status', ['issued', 'pending', 'cancelled'])->default('issued');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_cards');
    }
};