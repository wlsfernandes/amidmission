<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaType extends Model
{
  protected $fillable = [
    'name',
    'image_url',
    'description_en',
    'description_es',
    'slug',
    'is_active',
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];

  public function scopeVisible($query)
  {
    return $query->where('is_active', true);
  }
  protected static function booted()
  {
    static::creating(function (MediaType $type) {
      $type->slug = Str::slug($type->name);
    });
  }

  public function media()
  {
    return $this->hasMany(Media::class);
  }
  public function getDescriptionAttribute(): ?string
  {
    $locale = app()->getLocale();

    return $this->{'description_' . $locale}
      ?? $this->description_en;
  }
}
