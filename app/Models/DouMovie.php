<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DouMovie extends Model
{
    public function category()
    {
        return $this->belongsTo(DouCategory::class,'category_id','id');
    }

    public function comments()
    {
        return $this->hasMany(DouComment::class,'movie_id','id');
    }
}
