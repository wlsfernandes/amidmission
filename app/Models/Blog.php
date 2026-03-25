<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasTextLimits;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasTextLimits, HasFactory, Auditable;

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
        'publish_end_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function getTitle(): string
    {
        return app()->getLocale() === 'es'
            ? ($this->title_es ?: $this->title_en)
            : $this->title_en;
    }

    public function getContent(): string
    {
        return app()->getLocale() === 'es'
            ? ($this->content_es ?: $this->content_en)
            : $this->content_en;
    }

    /**
     * Boot method to handle slug generation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Blog $blog) {
            $blog->slug = static::generateUniqueSlug($blog->title_en);
        });

        static::updating(function (Blog $blog) {
            if ($blog->isDirty('title_en')) {
                $blog->slug = static::generateUniqueSlug(
                    $blog->title_en,
                    $blog->id
                );
            }
        });
    }

    protected static function booted()
    {
        static::updated(fn() => \Log::info('BLOG updated fired'));
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
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Scope: only currently visible blogs.
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

    public function hasDownloadFile(): bool
    {
        return !empty($this->getFileUrl());
    }

    public function getFileUrl(): ?string
    {
        return app()->getLocale() === 'es'
            ? ($this->file_url_es ?: $this->file_url_en)
            : ($this->file_url_en ?: $this->file_url_es);
    }
}
