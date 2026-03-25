<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->string('title_en');
            $table->string('title_es');
            $table->string('slug')->unique();
            $table->text('description_en')->nullable();
            $table->text('description_es')->nullable();

            $table->string('image_url')->nullable();
            $table->string('external_link')->nullable();

            $table->boolean('is_published')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
