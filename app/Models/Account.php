<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use SoftDeletes;

    //可修改字段
    protected $fillable = [
        'username', 'login_num', 'password','last_login_time','login_time','deleted_at','updated_at',
    ];

    //隐藏的字段
    protected $hidden = ['password'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'login_num' => 'integer',
    ];

    public function logs()
    {
        return $this->hasMany(AccountLog::class,'account_id','id');
    }
}
