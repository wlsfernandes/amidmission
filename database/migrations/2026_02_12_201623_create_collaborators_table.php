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
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();

            // Bilingual content
            $table->string('title_en');
            $table->string('title_es');

            $table->text('description_en')->nullable();
            $table->text('description_es')->nullable();

            // Timeline
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('slug')->nullable();
            $table->string('external_link')->nullable();

            $table->string('image_url')->nullable(); // Optional main image (S3 URL)

            // Publish toggle
            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborators');
    }
};
