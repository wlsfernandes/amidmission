<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
  protected $fillable = ['key', 'name'];

  public function teams()
  {
    return $this->belongsToMany(Team::class)->withTimestamps();
  }
}
