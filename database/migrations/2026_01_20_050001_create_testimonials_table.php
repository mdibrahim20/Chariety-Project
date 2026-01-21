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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->integer('rating')->unsigned()->default(5); // 1-5 stars
            $table->text('review_text');
            $table->string('reviewer_name');
            $table->string('reviewer_role')->nullable(); // Volunteer, Donor, etc.
            $table->string('avatar')->nullable(); // Path to avatar image
            $table->enum('status', ['active', 'disabled', 'pending'])->default('active');
            $table->integer('display_order')->default(0);
            $table->timestamps();
            
            $table->index('status');
            $table->index('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
