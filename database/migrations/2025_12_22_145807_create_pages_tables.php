<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_es')->nullable();

            // Banner image (top of page)
            $table->string('image_url')->nullable();

            // Slug for public URL
            $table->string('slug')->unique();

            // Content
            $table->longText('content_en')->nullable();
            $table->longText('content_es')->nullable();

            // Publish control
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
