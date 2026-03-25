<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Relationship
            $table->foreignId('store_id')
                ->constrained()
                ->cascadeOnDelete();

            // Identity
            $table->string('name');
            $table->string('slug')->unique();

            // Classification
            $table->string('type')->nullable(); // book, ebook, service, bundle

            // Multilingual content
            $table->text('description_en')->nullable();
            $table->text('description_es')->nullable();

            // Pricing
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('USD');

            // Inventory & delivery
            $table->string('sku')->nullable();
            $table->integer('stock')->nullable(); // null = unlimited
            $table->boolean('is_digital')->default(false);
            $table->string('file_url')->nullable(); // S3 (PDF, ZIP, etc.)

            // Media
            $table->string('image_url')->nullable();

            // Visibility
            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
