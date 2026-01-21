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
        Schema::create('contact_hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page_title')->default('Contact Us');
            $table->string('breadcrumb_home_label')->default('Home');
            $table->string('breadcrumb_current_label')->default('Contact Us');
            $table->string('background_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('overlay_enabled')->default(true);
            $table->integer('overlay_opacity')->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_hero_sections');
    }
};
