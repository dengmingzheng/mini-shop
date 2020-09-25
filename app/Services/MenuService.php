<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/11 0011
 * Time: 11:34
 */

namespace App\Services;

class MenuService extends BaseService
{
    public function __construct()
    {
        parent::__construct('Menu');
    }

    //获取顶级菜单和下级菜单
    public function getTopMenuWithChildren()
    {
        return $this->select(['id','title'])->getList(['parent_id'=>NULL],['children']);
    }
}