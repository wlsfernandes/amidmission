<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();

            // Author info
            $table->string('name')->nullable();
            $table->string('role')->nullable(); // e.g. Pastor, Student, Partner

            // Multilingual testimonial content
            $table->text('content_en');
            $table->text('content_es')->nullable();

            // Optional photo/avatar
            $table->string('image_url')->nullable();

            // Publish control
            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
