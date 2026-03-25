<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaboratorImage extends Model
{
  protected $fillable = [
    'collaborator_id',
    'image_url',
    'position',
    'caption_en',
    'caption_es',
    'external_link',
  ];

  /*
  |--------------------------------------------------------------------------
  | Relationships
  |--------------------------------------------------------------------------
  */

  public function collaborator()
  {
    return $this->belongsTo(Collaborator::class);
  }

  /*
  |--------------------------------------------------------------------------
  | Accessors (Locale-aware caption)
  |--------------------------------------------------------------------------
  */

  public function getCaptionAttribute(): ?string
  {
    $locale = app()->getLocale();

    return $this->{'caption_' . $locale}
      ?? $this->caption_en;
  }
}
