<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AboutSection;
use App\Traits\Auditable;

class About extends Model
{
  use HasFactory, Auditable;
  protected $table = 'abouts';
  protected $fillable = [
    'section',
    'sort_order',
    'title_en',
    'title_es',
    'subtitle_en',
    'subtitle_es',
    'content_en',
    'content_es',
    'image_url',
    'is_published',
    'publish_start_at',
    'publish_end_at',
  ];

  protected $casts = [
    'is_published' => 'boolean',
    'publish_start_at' => 'datetime',
    'publish_end_at' => 'datetime',
    'section' => AboutSection::class,
  ];

  /**
   * Scope: only currently visible About pages.
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

  /**
   * System logging for observability.
   */
  protected static function booted()
  {
    static::updated(fn() => \Log::info('ABOUT PAGE updated fired'));
  }
}
