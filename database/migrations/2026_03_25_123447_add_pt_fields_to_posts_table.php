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
            $table->string('title_pt')->nullable()->after('title_es');

        $table->longText('content_pt')->nullable()->after('content_es');

        // SEO
        $table->string('seo_title_pt')->nullable()->after('seo_title_es');
        $table->text('seo_description_pt')->nullable()->after('seo_description_es');

        // Open Graph
        $table->string('og_title_pt')->nullable()->after('og_title_es');
        $table->text('og_description_pt')->nullable()->after('og_description_es');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
            'title_pt',
            'content_pt',
            'seo_title_pt',
            'seo_description_pt',
            'og_title_pt',
            'og_description_pt',
        ]);
        });
    }
};
