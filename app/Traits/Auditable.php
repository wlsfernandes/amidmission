<?php

namespace App\Traits;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            self::audit('created', null, $model->getAttributes(), $model);
        });

        static::updated(function ($model) {
            self::audit(
                'updated',
                $model->getOriginal(),
                $model->getChanges(),
                $model
            );
        });

        static::deleted(function ($model) {
            self::audit('deleted', $model->getOriginal(), null, $model);
        });
    }

    protected static function audit(
        string $action,
        ?array $before,
        ?array $after,
        $model
    ): void {
        Audit::create([
            'user_id' => Auth::id(),
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'action' => $action,
            'before' => $before,
            'after' => $after,
            'ip_address' => Request::ip(),
        ]);
    }
}
