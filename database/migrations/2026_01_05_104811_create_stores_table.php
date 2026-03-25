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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();

            // Identity
            $table->string('name');
            $table->string('slug')->unique();

            // Classification
            $table->string('type')->nullable(); // book, digital, service, bundle

            // Multilingual content
            $table->text('content_en')->nullable();
            $table->text('content_es')->nullable();

            // Pricing
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');

            // Inventory / delivery
            $table->string('sku')->nullable();
            $table->integer('stock')->nullable(); // null = unlimited
            $table->boolean('is_digital')->default(false);
            $table->string('file_url')->nullable(); // S3 for digital items

            // Media
            $table->string('image_url')->nullable();

            // Visibility
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
