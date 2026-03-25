<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'sort_order',

        'title_en',
        'title_es',
        'title_pt',

        'content_en',
        'content_es',
        'content_pt',

        'image_url',
        'link_image',

        'external_link',
        'button_text',
        'button_position',
        'button_color',

        'type',
        'layout',
        'feature_type',

        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected $attributes = [
        'sort_order' => 0,
    ];
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function cards()
    {
        return $this->hasMany(SectionCard::class)->orderBy('sort_order');
    }

    public function images()
    {
        return $this->hasMany(SectionImage::class)->orderBy('sort_order');
    }

    /*
    |--------------------------------------------------------------------------
    | Localization Helpers
    |--------------------------------------------------------------------------
    */

    public function getTitle()
    {
        return $this->{'title_'.app()->getLocale()};
    }

    public function getContent()
    {
        return $this->{'content_'.app()->getLocale()};
    }

    public function getButtonText()
    {
        return $this->button_text ?: 'Learn More';
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('sort_order');
        });

        static::creating(function ($section) {

            // If sort_order is not defined or zero
            if (! $section->sort_order) {

                $maxOrder = self::where('page_id', $section->page_id)
                    ->max('sort_order');

                $section->sort_order = $maxOrder ? $maxOrder + 1 : 1;
            }

        });
    }
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
