<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $guarded = [];

    // Relasi: Tweet milik satu Kebijakan
    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}