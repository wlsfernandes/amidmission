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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            // Titles
            $table->string('title_en');
            $table->string('title_es')->nullable();

            // Short descriptions
            $table->text('description_en')->nullable();
            $table->text('description_es')->nullable();

            // File uploads (PDF, DOC, etc.)
            $table->string('file_url_en')->nullable();
            $table->string('file_url_es')->nullable();

            // Optional external link (Google Drive, partner site, etc.)
            $table->string('external_link')->nullable();

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
        Schema::dropIfExists('resources');
    }
};
