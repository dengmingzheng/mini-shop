<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/11 0011
 * Time: 19:17
 */

namespace App\Services;

use App\Models\Banner;

class BannerService extends BaseService
{
    public $types = [
        1=>'banner',
        2=>'导航'
    ];
    /**
     * 查询字段
     * @var array
     */
    public $field=['id','name','position','image_src','open_type','navigator_url','sort','status','created_at','updated_at'];

    /**
     * 每页显示的条数
     * @var number
     */
    public $perPage = 15;

    public function init($uniqueKey = '', $uniqueValue = '', $idKey = 'id')
    {
        $this->initialize(new Banner(), $uniqueKey, $uniqueValue, $idKey);
        return $this;
    }
}