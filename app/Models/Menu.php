<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable=['title','parent_id','group','url','sort','is_show','updated_at','deleted_at'];

    protected $casts=[
        'id'=>'integer',
        'parent_id'=>'integer',
        'sort'=>'integer',
        'is_show'=>'integer',
    ];

    //关联自身模型 获取父类
    public function parent()
    {
        return $this->belongsTo(Menu::class);
    }

    //关联自身模型 获取子类
    public function children()
    {
        return $this->hasMany(Menu::class,'parent_id');
    }
}
