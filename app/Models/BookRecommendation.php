<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class BookRecommendation extends Model
{
  use HasFactory, Auditable;

  protected $fillable = [
    'title_en',
    'title_es',
    'description_en',
    'description_es',
    'image_url',
    'external_link'
  ];

  /**
   * Localized title accessor
   */
  public function getTitleAttribute(): string
  {
    $locale = app()->getLocale();
    return $this->{'title_' . $locale} ?? $this->title_en;
  }

  /**
   * Localized description accessor
   */
  public function getDescriptionAttribute(): ?string
  {
    $locale = app()->getLocale();
    return $this->{'description_' . $locale} ?? $this->description_en;
  }

  /**
   * Lightweight observability
   */
  protected static function booted()
  {
    static::updated(fn() => \Log::info('BOOK RECOMMENDATION updated'));
  }
}
