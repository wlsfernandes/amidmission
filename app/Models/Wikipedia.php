<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wikipedia extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'created_by',
        'updated_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
