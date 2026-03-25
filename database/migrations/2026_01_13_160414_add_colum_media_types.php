<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('media_types', function (Blueprint $table) {
      $table->string('image_url')->nullable()->after('slug');
      $table->text('description_en')->nullable()->after('image_url');
      $table->text('description_es')->nullable()->after('description_en');
    });
  }

  public function down(): void
  {
    Schema::table('media_types', function (Blueprint $table) {
      $table->dropColumn([
        'image_url',
        'description_en',
        'description_es',
      ]);
    });
  }
};
