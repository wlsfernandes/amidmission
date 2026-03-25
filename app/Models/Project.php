<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
  protected $fillable = [
    'title_en',
    'title_es',
    'image_url',
    'slug',
    'description_en',
    'description_es',
    'start_date',
    'end_date',
    'is_published',
    'external_link',
    'order',
    ];

  protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'is_published' => 'boolean',
  ];

  /*
  |--------------------------------------------------------------------------
  | Relationships
  |--------------------------------------------------------------------------
  */

  public function images()
  {
    return $this->hasMany(ProjectImage::class)->orderBy('position');
  }

  /*
  |--------------------------------------------------------------------------
  | Slug handling (same pattern as Page)
  |--------------------------------------------------------------------------
  */

  protected static function boot()
  {
    parent::boot();

    static::creating(function (Project $project) {
      $project->slug = static::generateUniqueSlug($project->title_en);
    });

    static::updating(function (Project $project) {
      if ($project->isDirty('title_en')) {
        $project->slug = static::generateUniqueSlug(
          $project->title_en,
          $project->id
        );
      }
    });
  }

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

  /*
  |--------------------------------------------------------------------------
  | Locale-aware accessors
  |--------------------------------------------------------------------------
  */

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

  /*
  |--------------------------------------------------------------------------
  | Scopes
  |--------------------------------------------------------------------------
  */

  /**
   * Scope: only visible team members.
   */
  public function scopeVisible($query)
  {
    return $query->where('is_published', true);
  }

   public function getBannerUrlAttribute(): string
    {
        return $this->image_url
            ? route('admin.images.preview', [
            'model' => 'projects',
            'id'    => $this->id,
        ])
            : asset('assets/frontend/img/banner/breadcumd-bg.jpg');
    }

}
