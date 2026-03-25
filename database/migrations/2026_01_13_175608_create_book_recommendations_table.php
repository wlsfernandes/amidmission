<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('book_recommendations', function (Blueprint $table) {
      $table->id();

      $table->string('title_en');
      $table->string('title_es')->nullable();

      $table->string('description_en')->nullable();
      $table->string('description_es')->nullable();

      $table->string('image_url')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('book_recommendations');
  }
};
