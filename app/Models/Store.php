<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'slug',
        'type',

        'content_en',
        'content_es',

        'image_url',

        'is_published',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Booted model events
     */
    protected static function booted(): void
    {
        static::creating(function (Store $store) {
            if (empty($store->slug)) {
                $store->slug = static::generateUniqueSlug($store->name);
            }
        });

        static::updating(function (Store $store) {
            if ($store->isDirty('name')) {
                $store->slug = static::generateUniqueSlug(
                    $store->name,
                    $store->id
                );
            }
        });
    }

    /**
     * Relationships
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Helpers
     */
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
}
