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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_es')->nullable();

            $table->text('subtitle_en')->nullable();
            $table->text('subtitle_es')->nullable();

            $table->string('link')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('open_in_new_tab')->default(false);

            $table->boolean('is_published')->default(false);
            $table->date('publish_start_at')->nullable();
            $table->date('publish_end_at')->nullable();

            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
