<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    // Izinkan semua kolom diisi (Mass Assignment)
    protected $guarded = [];

    // Relasi: Satu Kebijakan punya banyak Tweets
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }
}