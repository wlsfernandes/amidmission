<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use App\Enums\SocialPlatform;

class SocialLink extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'platform',
        'url',
        'order',
        'is_published',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'platform' => SocialPlatform::class, // ✅ enum casting
    ];

    /**
     * Scope: only active social links.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordered social links.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Convenience: icon class from enum.
     */
    public function icon(): string
    {
        return $this->platform->icon();
    }

    /**
     * Convenience: label from enum.
     */
    public function label(): string
    {
        return $this->platform->label();
    }

    /**
     * Lightweight observability.
     * Full logging handled in controller.
     */
    protected static function booted()
    {
        static::updated(fn() => \Log::info('SOCIAL LINK updated fired'));
    }
}
