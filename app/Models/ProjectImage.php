<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $fillable = [
        'project_id',
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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /*
  |--------------------------------------------------------------------------
  | Accessors (Locale-aware caption)
  |--------------------------------------------------------------------------
  */

    public function getCaptionAttribute(): ?string
    {
        $locale = app()->getLocale();

        return $this->{'caption_' . $locale} ?? $this->caption_en;
    }
}
