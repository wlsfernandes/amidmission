<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();

            // Multilingual titles
            $table->string('title_en');
            $table->string('title_es')->nullable();

            // Multilingual subtitles
            $table->string('subtitle_en')->nullable();
            $table->string('subtitle_es')->nullable();

            // Multilingual content
            $table->text('content_en')->nullable();
            $table->text('content_es')->nullable();

            // Media
            $table->string('image_url')->nullable();

            // Publishing controls
            $table->boolean('is_published')->default(false);
            $table->timestamp('publish_start_at')->nullable();
            $table->timestamp('publish_end_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
