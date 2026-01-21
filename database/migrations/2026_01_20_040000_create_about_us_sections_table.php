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
        Schema::create('about_us_sections', function (Blueprint $table) {
            $table->id();
            
            // Left Content
            $table->string('badge_text')->nullable();
            $table->string('main_heading');
            $table->text('description')->nullable();
            
            // Feature Card 1
            $table->string('feature1_icon')->nullable(); // Path to SVG or icon identifier
            $table->string('feature1_title')->nullable();
            $table->text('feature1_description')->nullable();
            
            // Feature Card 2
            $table->string('feature2_icon')->nullable();
            $table->string('feature2_title')->nullable();
            $table->text('feature2_description')->nullable();
            
            // Right Content
            $table->text('right_paragraph')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->string('cta_button_link')->nullable();
            $table->enum('cta_button_target', ['_self', '_blank'])->default('_self');
            
            // Images
            $table->string('image1')->nullable(); // Main large image (416×659)
            $table->string('image2')->nullable(); // Small image (196×312)
            
            // Status
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us_sections');
    }
};
