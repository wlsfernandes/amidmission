<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\Auditable;

class Position extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'title_en',
        'title_es',
        'slug',
        'content_en',
        'content_es',
        'publish_start_at',
        'publish_end_at',
        'is_published',
        'image_url',
        'file_url_en',
        'file_url_es',
        'external_link',
    ];

    protected $casts = [
        'publish_start_at' => 'datetime',
        'publish_end_at'   => 'datetime',
        'is_published'     => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeVisible($query)
    {
        return $query
            ->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('publish_start_at')
                  ->orWhere('publish_start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('publish_end_at')
                  ->orWhere('publish_end_at', '>=', now());
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Slug Handling
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($position) {
            $position->slug = self::generateUniqueSlug($position->title_en);
        });

        static::updating(function ($position) {
            if ($position->isDirty('title_en')) {
                $position->slug = self::generateUniqueSlug($position->title_en);
            }
        });
    }

    protected static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (Optional but Recommended)
    |--------------------------------------------------------------------------
    */

    public function getTitle()
    {
        $locale = app()->getLocale();
        return $this->{'title_' . $locale} ?? $this->title_en;
    }

    public function getDescription()
    {
        $locale = app()->getLocale();
        return $this->{'content_' . $locale} ?? $this->content_en;
    }

    public function getFileUrl(): ?string
    {
        return app()->getLocale() === 'es'
            ? ($this->file_url_es ?: $this->file_url_en)
            : ($this->file_url_en ?: $this->file_url_es);
    }
}
