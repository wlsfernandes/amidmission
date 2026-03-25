<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();

            // Multilingual title
            $table->string('title_en');
            $table->string('title_es')->nullable();

            // Multilingual content
            $table->text('content_en')->nullable();
            $table->text('content_es')->nullable();

            // Media & files
            $table->string('image_url')->nullable();
            $table->string('file_url_en')->nullable();
            $table->string('file_url_es')->nullable();

            // External application link
            $table->string('external_link')->nullable();

            // Publishing controls
            $table->boolean('is_published')->default(false);
            $table->timestamp('publish_start_at')->nullable();
            $table->timestamp('publish_end_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
