<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Resource extends Model
{
  use HasFactory, Auditable;

  protected $fillable = [
    'title_en',
    'title_es',
    'description_en',
    'description_es',
    'file_url_en',
    'file_url_es',
    'external_link',
    'is_published',
    'image_url',
  ];

  protected $casts = [
    'is_published' => 'boolean',
  ];

  /**
   * Scope: only published resources.
   */
  public function scopeVisible($query)
  {
    return $query->where('is_published', true);
  }

  /**
   * Lightweight model-level observability.
   * Full logging handled in controllers via SystemLogger.
   */
  protected static function booted()
  {
    static::updated(fn() => \Log::info('RESOURCE updated fired'));
  }

  public function getTitleAttribute(): string
  {
    $locale = app()->getLocale();
    return $this->{'title_' . $locale} ?? $this->title_en;
  }

  public function getDescriptionAttribute(): ?string
  {
    $locale = app()->getLocale();
    return $this->{'description_' . $locale} ?? $this->description_en;
  }

  public function getFileUrlAttribute(): ?string
  {
    $locale = app()->getLocale();
    return $this->{'file_url_' . $locale} ?? $this->file_url_en;
  }

}
