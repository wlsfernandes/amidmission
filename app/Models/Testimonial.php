<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Testimonial extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'role',
        'content_en',
        'content_es',
        'image_url',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Scope: only published testimonials.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Lightweight model-level observability.
     * Controller handles full SystemLogger logging.
     */
    protected static function booted()
    {
        static::updated(fn() => \Log::info('TESTIMONIAL updated fired'));
    }
}
