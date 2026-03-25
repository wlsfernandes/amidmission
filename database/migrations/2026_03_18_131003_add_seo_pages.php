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
        Schema::table('pages', function (Blueprint $table) {

            // ✅ SEO Core
            $table->string('seo_title_en')->nullable()->after('content_es');
            $table->string('seo_title_es')->nullable()->after('seo_title_en');

            $table->text('seo_description_en')->nullable()->after('seo_title_es');
            $table->text('seo_description_es')->nullable()->after('seo_description_en');

            $table->text('seo_keywords')->nullable()->after('seo_description_es');

            // ✅ Open Graph (Social Sharing)
            $table->string('og_title_en')->nullable()->after('seo_keywords');
            $table->string('og_title_es')->nullable()->after('og_title_en');

            $table->text('og_description_en')->nullable()->after('og_title_es');
            $table->text('og_description_es')->nullable()->after('og_description_en');

            $table->string('og_image_url')->nullable()->after('og_description_es');

            // ✅ Indexing Control
            $table->boolean('no_index')->default(false)->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'seo_title_en',
                'seo_title_es',
                'seo_description_en',
                'seo_description_es',
                'seo_keywords',
                'og_title_en',
                'og_title_es',
                'og_description_en',
                'og_description_es',
                'og_image_url',
                'no_index',
            ]);
        });
    }
};