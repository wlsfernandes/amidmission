<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('project_images', function (Blueprint $table) {
      $table->id();

      // Relationship
      $table->foreignId('project_id')
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

  public function down(): void
  {
    Schema::dropIfExists('project_images');
  }
};
