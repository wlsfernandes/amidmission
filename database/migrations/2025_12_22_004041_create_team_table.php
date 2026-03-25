<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();

            // Identity
            $table->string('name');
            $table->string('slug')->unique();

            // Optional role / title
            $table->string('role')->nullable();

            // Multilingual bio
            $table->text('content_en')->nullable();
            $table->text('content_es')->nullable();

            // Media
            $table->string('image_url')->nullable();

            // Publish control
            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
