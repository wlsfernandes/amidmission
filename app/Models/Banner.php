<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use Auditable;

    protected $fillable = [
        'page_id',
        'title_en',
        'title_es',
        'title_pt',
        'subtitle_en',
        'subtitle_es',
        'subtitle_pt',
        'image_url',
        'link',
        'open_in_new_tab',
        'is_published',
        'publish_start_at',
        'publish_end_at',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'open_in_new_tab' => 'boolean',
        'publish_start_at' => 'date',
        'publish_end_at' => 'date',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $now = now();

                $q->whereNull('publish_start_at')
                    ->orWhere('publish_start_at', '<=', $now);
            })
            ->where(function ($q) {
                $now = now();

                $q->whereNull('publish_end_at')
                    ->orWhere('publish_end_at', '>=', $now);
            });
    }

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        $field = 'title_' . $locale;
    
        return !empty($this->{$field})
            ? $this->{$field}
            : ($this->title_en ?? '');
    }
    
    public function getSubtitleAttribute()
    {
        $locale = app()->getLocale();
        $field = 'subtitle_' . $locale;
    
        return !empty($this->{$field})
            ? $this->{$field}
            : ($this->subtitle_en ?? '');
    }
}
