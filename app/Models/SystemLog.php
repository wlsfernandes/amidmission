<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
        'user_id',
        'level',
        'action',
        'message',
        'context',
        'ip_address',
        'url',
    ];

    protected $casts = [
        'context' => 'array',
    ];
}
