<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Page extends Model
{
    use Auditable, HasFactory;

    protected $fillable = [
    'title_en',
    'title_es',
    'title_pt',

    'slug',
    'image_url',

    'content_en',
    'content_es',
    'content_pt',

    'is_published',

    // ✅ SEO Core
    'seo_title_en',
    'seo_title_es',
    'seo_title_pt',

    'seo_description_en',
    'seo_description_es',
    'seo_description_pt',

    'seo_keywords', // JSON or comma string

    // ✅ Social / Open Graph
    'og_title_en',
    'og_title_es',
    'og_title_pt',

    'og_description_en',
    'og_description_es',
    'og_description_pt',

    'og_image_url',

    // ✅ Indexing control
    'no_index',
];

    protected $casts = [
        'is_published' => 'boolean',
        'no_index' => 'boolean',
    ];

    public function banners()
    {
        return $this->hasMany(Banner::class, 'page_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class)
            ->where('is_published', true);
    }

    /**
     * Boot method to handle slug generation.
     */
    protected static function boot()
    {
        parent::boot();

       static::creating(function (Page $page) {
    if (empty($page->slug)) {
        $page->slug = static::generateUniqueSlug($page->title_en);
    }
});

    }

    /**
     * Generate a unique slug based on the English title.
     */
    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Scope: only visible pages.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Lightweight model-level observability.
     * Controller handles full SystemLogger logging.
     */
    protected static function booted()
    {
        static::updated(fn () => Log::info('PAGE updated fired'));
    }

    /**
     * Get title based on current locale.
     */
    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->{'title_'.$locale} ?? $this->title_en;
    }

    /**
     * Get content/description based on current locale.
     */
    public function getContentAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $this->{'content_'.$locale} ?? $this->content_en;
    }

    public function getUrlAttribute(): string
    {
        return url($this->slug);
    }

    public function getSeoTitleAttribute()
{
    return $this->{'seo_title_' . app()->getLocale()} 
        ?? $this->title;
}

public function getSeoDescriptionAttribute()
{
    return $this->{'seo_description_' . app()->getLocale()} 
        ?? \Str::limit(strip_tags($this->{'content_' . app()->getLocale()}), 160);
}
}
