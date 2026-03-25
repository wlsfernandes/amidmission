<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // Prevent duplicate home page
        if (Page::where('slug', 'home')->exists()) {
            return;
        }

        Page::create([
            'title_en' => 'Home',
            'title_es' => 'Inicio',
            'title_pt' => 'Início',

            'slug' => 'home',

            'image_url' => '/images/home-banner.jpg',

            'content_en' => '<h1>Welcome to Amid Mission</h1><p>We serve communities worldwide.</p>',
            'content_es' => '<h1>Bienvenido a Amid Mission</h1><p>Servimos comunidades en todo el mundo.</p>',
            'content_pt' => '<h1>Bem-vindo à Amid Mission</h1><p>Servimos comunidades em todo o mundo.</p>',

            'is_published' => true,

            // SEO
            'seo_title_en' => 'Amid Mission - Home',
            'seo_title_es' => 'Amid Mission - Inicio',
            'seo_title_pt' => 'Amid Mission - Início',

            'seo_description_en' => 'Welcome to Amid Mission official website.',
            'seo_description_es' => 'Bienvenido al sitio oficial de Amid Mission.',
            'seo_description_pt' => 'Bem-vindo ao site oficial da Amid Mission.',

            'seo_keywords' => json_encode(['mission', 'community', 'faith']),

            // Open Graph
            'og_title_en' => 'Amid Mission',
            'og_title_es' => 'Amid Mission',
            'og_title_pt' => 'Amid Mission',

            'og_description_en' => 'Serving communities globally.',
            'og_description_es' => 'Sirviendo comunidades globalmente.',
            'og_description_pt' => 'Servindo comunidades globalmente.',

            'og_image_url' => '/images/og-home.jpg',

            'no_index' => false,
        ]);
    }
}