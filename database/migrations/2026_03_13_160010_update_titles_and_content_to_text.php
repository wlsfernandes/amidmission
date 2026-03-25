<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {

            $table->text('title_en')->nullable()->change();
            $table->text('title_es')->nullable()->change();

            $table->text('content_en')->nullable()->change();
            $table->text('content_es')->nullable()->change();

        });

        Schema::table('section_cards', function (Blueprint $table) {

            $table->text('title_en')->nullable()->change();
            $table->text('title_es')->nullable()->change();

            $table->text('content_en')->nullable()->change();
            $table->text('content_es')->nullable()->change();

        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {

            $table->string('title_en')->nullable()->change();
            $table->string('title_es')->nullable()->change();

            $table->text('content_en')->nullable()->change();
            $table->text('content_es')->nullable()->change();

        });

        Schema::table('section_cards', function (Blueprint $table) {

            $table->string('title_en')->nullable()->change();
            $table->string('title_es')->nullable()->change();

            $table->text('content_en')->nullable()->change();
            $table->text('content_es')->nullable()->change();

        });
    }
};
