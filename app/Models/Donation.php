<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'title_en',
        'title_es',
        'description_en',
        'description_es',
        'suggested_amount',
        'currency',
        'image_url',
        'is_published',
    ];

    /**
     * Get title based on current locale
     */
    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        $field = 'title_' . $locale;
    
        return $this->{$field}
            ?? $this->title_en
            ?? '';
    }

    /**
     * Get description based on current locale
     */
    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        $field = 'description_' . $locale;  

        return $this->{$field}
            ?? $this->description_en
            ?? '';
    }

    /**
     * Scope: only published donations
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
