<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasTextLimits
{
    public function limitText(string $text, int $limit = 120): string
    {
        return Str::limit(
            strip_tags($text),
            $limit
        );
    }
}
