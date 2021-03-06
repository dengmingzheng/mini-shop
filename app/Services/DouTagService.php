<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/22 0022
 * Time: 11:44
 */

namespace App\Services;


class DouTagService extends BaseService
{
    public function __construct()
    {
        parent::__construct('DouTag');
    }

    public function getListByIds($ids,$field = [])
    {
        $query = $this->model->whereIn('id',$ids);

        if($field){
            $list = $query->select($field)->get();
        }else{
            $list = $query->get();
        }

        return $list->toArray();
    }
}