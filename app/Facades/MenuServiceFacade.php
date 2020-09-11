<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/11 0011
 * Time: 11:37
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MenuServiceFacade extends Facade
{
    /**
     * 获取组件的注册名称。
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'MenuService';
    }

}