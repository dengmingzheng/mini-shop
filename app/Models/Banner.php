<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $casts=[
        'id'=>'integer',
        'type'=>'integer',
        'sort'=>'integer',
        'status'=>'integer',
    ];
}
