<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class GalleryImage extends Model
{
  protected $fillable = [
    'image_url',
    'is_published',
  ];

  protected $casts = [
    'is_published' => 'boolean',
  ];

  public function scopeVisible($query)
  {
    return $query->where('is_published', true);
  }
}
