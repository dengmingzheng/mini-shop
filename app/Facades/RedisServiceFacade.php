<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/11 0011
 * Time: 10:53
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class RedisServiceFacade extends Facade
{
    /**
     * 获取组件的注册名称。
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'RedisService';
    }
}