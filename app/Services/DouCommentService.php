<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/24 0024
 * Time: 18:08
 */

namespace App\Services;


class DouCommentService extends BaseService
{
    public function __construct()
    {
        parent::__construct('DouComment');
    }

    public function getListWithPageByCondition(array $condition =[],array $with=[],$order = 'id', $desc = 'DESC', $page = 15)
    {
        $query = $this->model;

        if(!empty($condition)){
            foreach ($condition as $key=>$value){
                if($key === 'user_id' && is_array($value)){
                    $query = $query->whereIn('user_id',$value);
                }elseif ($key === 'movie_id' && is_array($value)){
                    $query = $query->whereIn('movie_id',$value);
                }else{
                    $query = $query->where($key,$value);
                }
            }
        }

        return $query->orderBy($order, $desc)->select($this->getField())->with($with)->paginate($page);

    }
}