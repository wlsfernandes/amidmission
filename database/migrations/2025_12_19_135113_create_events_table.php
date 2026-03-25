<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Core content
            $table->string('title_en');
            $table->string('title_es')->nullable();
            $table->string('slug')->unique();

            $table->longText('content_en')->nullable();
            $table->longText('content_es')->nullable();

            // Event timing
            $table->dateTime('event_date')->nullable();

            // Publication control
            $table->dateTime('publish_start_at')->nullable();
            $table->dateTime('publish_end_at')->nullable();
            $table->boolean('is_published')->default(false);

            // Media & files
            $table->string('image_url')->nullable();
            $table->string('file_url_en')->nullable();
            $table->string('file_url_es')->nullable();
            $table->string('external_link')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('event_date');
            $table->index('is_published');
            $table->index('publish_start_at');
            $table->index('publish_end_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
