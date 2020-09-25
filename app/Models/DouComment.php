<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DouComment extends Model
{
    public function movie()
    {
        return $this->belongsTo(DouMovie::class,'movie_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
