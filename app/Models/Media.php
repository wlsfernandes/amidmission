<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Media extends Model
{
  use Auditable;

  protected $fillable = [
    'media_type_id',
    'title_en',
    'title_es',
    'description_en',
    'description_es',
    'external_link',
    'published_at',
    'is_published',
  ];

  protected $casts = [
    'is_published' => 'boolean',
    'published_at' => 'date',
  ];

  /* ============================
   | Relationships
   ============================ */
  public function type()
  {
    return $this->belongsTo(MediaType::class, 'media_type_id');
  }

  /* ============================
   | Localization Accessors
   ============================ */
  public function getTitleAttribute(): string
  {
    $locale = app()->getLocale();

    return $this->{'title_' . $locale}
      ?? $this->title_en;
  }

  public function getDescriptionAttribute(): ?string
  {
    $locale = app()->getLocale();

    return $this->{'description_' . $locale}
      ?? $this->description_en;
  }

  /* ============================
   | Scopes
   ============================ */
  public function scopeVisible($query)
  {
    return $query->where('is_published', true);
  }
}
