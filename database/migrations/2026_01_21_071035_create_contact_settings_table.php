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
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            // Section Text
            $table->string('badge_label')->nullable();
            $table->string('main_heading')->default('Reach Together, We Can Make a Difference');
            $table->text('description')->nullable();
            $table->string('submit_button_text')->default('Send Now');
            
            // Google Map
            $table->text('google_map_embed')->nullable();
            
            // Subject Options (comma-separated)
            $table->text('subject_options')->nullable();
            
            // Card 1: Call Us Today
            $table->boolean('card_phone_enabled')->default(true);
            $table->string('card_phone_title')->default('Call Us Today');
            $table->string('card_phone_subtitle')->nullable();
            $table->string('card_phone_1')->nullable();
            $table->string('card_phone_2')->nullable();
            $table->string('card_phone_icon')->nullable();
            
            // Card 2: Mail Information
            $table->boolean('card_email_enabled')->default(true);
            $table->string('card_email_title')->default('Mail Information');
            $table->string('card_email_subtitle')->nullable();
            $table->string('card_email_1')->nullable();
            $table->string('card_email_2')->nullable();
            $table->string('card_email_icon')->nullable();
            
            // Card 3: Our Location
            $table->boolean('card_location_enabled')->default(true);
            $table->string('card_location_title')->default('Our Location');
            $table->string('card_location_subtitle')->nullable();
            $table->text('card_location_address')->nullable();
            $table->string('card_location_icon')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};
