<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasTextLimits;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Support\Str;

class Team extends Model
{
  use HasFactory, Auditable, HasTextLimits;

  protected $fillable = [
    'name',
    'slug',
    'role',
    'content_en',
    'content_es',
    'image_url',
    'is_published',
  ];

  protected $casts = [
    'is_published' => 'boolean',
  ];

  /* ---------------- Relations ---------------- */

  public function sectors()
  {
    return $this->belongsToMany(Sector::class)->withTimestamps();
  }

  /* ---------------- Slug logic (unchanged) ---------------- */
  protected static function boot()
  {
    parent::boot();

    static::creating(
      fn(Team $team) =>
      $team->slug = static::generateUniqueSlug($team->name)
    );

    static::updating(function (Team $team) {
      if ($team->isDirty('name')) {
        $team->slug = static::generateUniqueSlug($team->name, $team->id);
      }
    });
  }

  protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
  {
    $slug = Str::slug($name);
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

  /* ---------------- Scopes ---------------- */

  public function scopeVisible($query)
  {
    return $query->where('is_published', true);
  }


}
