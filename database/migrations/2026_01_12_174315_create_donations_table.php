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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            // Bilingual content
            $table->string('title_en');
            $table->string('title_es');

            $table->text('description_en')->nullable();
            $table->text('description_es')->nullable();

            // Optional suggested amount
            $table->decimal('suggested_amount', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');

            // Image (S3)
            $table->string('image_url')->nullable();

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
        Schema::dropIfExists('donations');
    }
};
