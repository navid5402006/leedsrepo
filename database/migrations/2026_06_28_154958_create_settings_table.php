<?php
// database/migrations/2025_06_28_000001_create_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // ─── Institute Information ───
            $table->string('institute_logo')->nullable();
            $table->string('institute_name')->default('Leeds Institute');
            $table->string('tagline')->nullable();
            $table->text('about_description')->nullable();
            $table->integer('years_experience')->default(0);
            $table->text('address')->nullable();
            $table->string('google_map_embed_url')->nullable();

            // ─── CEO Information ───
            $table->string('ceo_name')->nullable();
            $table->string('ceo_designation')->nullable();
            $table->string('ceo_photo')->nullable();
            $table->text('ceo_vision')->nullable();
            $table->text('ceo_message')->nullable();
            $table->string('ceo_signature')->nullable();

            // ─── About Institute ───
            $table->text('about_us')->nullable();
            $table->text('our_mission')->nullable();
            $table->text('our_vision')->nullable();
            $table->text('why_choose_us')->nullable();
            $table->string('institute_image')->nullable();
            $table->string('achievement_counter')->nullable();

            // ─── Contact Information ───
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->text('contact_address')->nullable();
            $table->string('google_maps_url')->nullable();

            // ─── Social Media ───
            $table->string('facebook_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};