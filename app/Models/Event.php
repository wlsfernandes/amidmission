<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasTextLimits;
use App\Traits\Auditable;
use Illuminate\Support\Str;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Auditable, HasTextLimits;

    protected $fillable = [
        'title_en',
        'title_es',
        'slug',
        'content_en',
        'content_es',
        'event_date',
        'publish_start_at',
        'publish_end_at',
        'is_published',
        'image_url',
        'file_url_en',
        'file_url_es',
        'external_link',
    ];

    protected $casts = [
        'event_date' => 'datetime',
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

        static::creating(function (Event $event) {
            $event->slug = static::generateUniqueSlug($event->title_en);
        });

        static::updating(function (Event $event) {
            if ($event->isDirty('title_en')) {
                $event->slug = static::generateUniqueSlug(
                    $event->title_en,
                    $event->id
                );
            }
        });
    }
    protected static function booted()
    {
        static::updated(fn() => \Log::info('EVENT updated fired'));
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
     * Scope: only currently visible events.
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
