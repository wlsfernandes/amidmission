<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'sort_order',

        'title_en',
        'title_es',

        'content_en',
        'content_es',

        'image_url',

        'link',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function section()
    {
        return $this->belongsTo(Section::class);
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
}
