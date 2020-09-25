<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{
    //后台用户关联模型
    public function account()
    {
        return $this->belongsTo('App\Models\Account','account_id','id');
    }
}
