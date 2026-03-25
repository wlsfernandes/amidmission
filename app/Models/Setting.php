<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Setting extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'site_name',
        'image_url',          // logo
        'favicon_url',

        'contact_email',
        'contact_phone',
        'address',

        'footer_text',

        'default_seo_title',
        'default_seo_description',

    ];

    /**
     * Get the singleton settings record.
     * Always returns one row.
     */
    public static function current(): self
    {
        return static::first() ?? static::create();
    }

    /**
     * Prevent creating multiple settings rows accidentally.
     */
    protected static function booted()
    {
        static::creating(function () {
            if (static::count() > 0) {
                throw new \RuntimeException('Only one settings record is allowed.');
            }
        });

        static::updated(fn() => \Log::info('SETTINGS updated fired'));
    }
}
