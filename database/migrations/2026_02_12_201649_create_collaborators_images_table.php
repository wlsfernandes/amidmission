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
        Schema::create('collaborator_images', function (Blueprint $table) {
            $table->id();

            // Relationship
            $table->foreignId('collaborator_id')
                ->constrained()
                ->cascadeOnDelete();

            // Image (S3)
            $table->string('image_url');

            // Optional ordering
            $table->unsignedInteger('position')->default(0);

            // Optional bilingual captions
            $table->string('caption_en')->nullable();
            $table->string('caption_es')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborator_images');
    }
};
