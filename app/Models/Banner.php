<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable=['name','position','image_src','open_type','navigator_url','sort','status','updated_at','deleted_at'];

    protected $casts=[
        'id'=>'integer',
        'sort'=>'integer',
        'status'=>'integer',
    ];
}
