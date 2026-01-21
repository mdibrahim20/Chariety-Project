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
        Schema::create('newsletter_sections', function (Blueprint $table) {
            $table->id();
            $table->string('heading_text');
            $table->text('description_text')->nullable();
            $table->string('email_placeholder')->default('Enter Your Email...');
            $table->string('button_text')->default('Subscribe');
            $table->string('success_message')->default('Thanks for subscribing!');
            $table->string('error_message')->nullable();
            $table->string('background_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('overlay_enabled')->default(true);
            $table->integer('overlay_opacity')->default(50); // 0-100
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletter_sections');
    }
};
