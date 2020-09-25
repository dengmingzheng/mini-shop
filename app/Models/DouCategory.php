<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DouCategory extends Model
{
    public function movies()
    {
        return $this->hasMany(DouMovie::class,'category_id','id');
    }
}
