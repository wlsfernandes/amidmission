<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionImage extends Model
{
    protected $fillable = [

        'section_id',
        'image_url',

        'title_en',
        'title_es',

        'external_link',

        'sort_order',
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
    | Localization Helper
    |--------------------------------------------------------------------------
    */

    public function getTitle()
    {
        return $this->{'title_'.app()->getLocale()};
    }
}
