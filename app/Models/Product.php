<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'store_id',

        'name',
        'slug',
        'type',

        'description_en',
        'description_es',

        'price',
        'currency',

        'sku',
        'stock',
        'is_digital',
        'file_url',

        'image_url',

        'is_published',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_digital' => 'boolean',
        'is_published' => 'boolean',
        'stock' => 'integer',
    ];

    /**
     * Booted model events
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name')) {
                $product->slug = static::generateUniqueSlug(
                    $product->name,
                    $product->id
                );
            }
        });
    }

    /**
     * Relationships
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
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
