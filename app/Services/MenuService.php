<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/11 0011
 * Time: 11:34
 */

namespace App\Services;

use App\Models\Menu;

class MenuService extends BaseService
{
    /**
     * 所有关联关系
     *
     * @var array
     */
    public $withAll = ['parent','children'];

    /**
     * 查询字段
     * @var array
     */
    public $field=['id','title','parent_id','group','url','sort','is_show','created_at','updated_at'];

    /**
     * 每页显示的条数
     * @var number
     */
    public $perPage = 15;

    public function init($uniqueKey = '', $uniqueValue = '', $idKey = 'id')
    {
        $this->initialize(new Menu(), $uniqueKey, $uniqueValue, $idKey);
        return $this;
    }

    //获取顶级菜单和下级子菜单
    public function getTopMenuWithChildren()
    {
        return $this->where(['parent_id'=>NULL])->orderBy('sort','ASC')->with(['children'])->getList(false)[0]['data'];
    }

}