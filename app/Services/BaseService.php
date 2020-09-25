<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/22 0022
 * Time: 9:13
 */

namespace App\Services;

use Illuminate\Support\Facades\Schema;

class BaseService
{
    /**
     * @var 模型
     */
    public $model;

    /**
     * @var array 查询的字段
     */
    public $field = [];

    public function __construct($modelName = null)
    {
        if (!empty($modelName)) {
            $m = '\\App\\Models\\' . $modelName;
            $this->model = new $m();
        }

    }

    /**
     * @param array $field设置查询字段
     */
    public function select(array $field)
    {
        if(!is_array($field) && empty($field)){
            $this->field = Schema::getColumnListing($this->model->getTable());
        }else{
            $this->field = $field;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getField()
    {
       return  $this->field ? $this->field : Schema::getColumnListing($this->model->getTable());

    }

    /**
     * 获取分页列表
     * @param array $condition
     * @param array $with
     * @param string $order
     * @param string $desc
     * @param int $page
     * @return mixed
     */
    public function getListWithPage(array $condition =[],array $with=[],$order = 'id', $desc = 'DESC', $page = 15)
    {
        return $this->model->where($condition)->orderBy($order, $desc)->select($this->getField())->with($with)->paginate($page);
    }

    /**
     * 根据条件获取列表
     * @param array $condition
     * @param array $with
     * @param string $order
     * @param string $desc
     * @return array
     */
    public function getList(array $condition = [],array $with=[],$order = 'id', $desc = 'DESC',$skip = "", $perPage = "")
    {
        $select = $this->model->select($this->getField())->where($condition)->orderBy($order,$desc);

        if(!empty($with)){
            $select = $select->with($with);
        }

        //分页
        if (empty($skip) && empty($perPage)) {
            $data = $select->get();
        } else {
            $data = $select->skip($skip)->take($perPage)->get();
        }

        if (!empty(($data))) {
            return $data->toArray();
        } else {
            return [];
        }
    }

    public function getPluckValue(string $value,array $condition)
    {
        return $this->model->where($condition)->get()->pluck($value)->toArray();
    }
    /**
     * 根据ID获取单条数据
     * @param $id
     * @return array
     */
    public function getRowById(int $id,array $with = [])
    {
        if(is_array($with) && !empty($with)){
            $data = $this->model->select($this->getField())->with($with)->find($id);
        }else{
            $data = $this->model->select($this->getField())->find($id);
        }

        if (!empty(($data))) {
            return $data->toArray();
        } else {
            return [];
        }
    }

    /**
     * 根据条件获取单条数据
     * @param array $condition
     * @return array
     */
    public function getRowByCondition(array $condition,array $with = [])
    {
        if (!is_array($condition) && empty($condition)) {
            return [];
        }

        $query = $this->model->where($condition)->select($this->getField());

        if(is_array($with) && !empty($with)){
            $data = $query->with($with)->first();
        }else{
            $data = $query->first();
        }

        if (!empty(($data))) {
            return $data->toArray();
        } else {
            return [];
        }
    }

    /**
     * 添加单条数据返回自增ID
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {
        return $this->model->insertGetId($data);
    }

    /**
     * 根据条件修改数据
     * @param array $condition
     * @param array $data
     * @return bool
     */
    public function update(array $condition,array $data)
    {
        if(!is_array($condition) && empty($condition)){
            return false;
        }

        return $this->model->where($condition)->update($data);
    }
    /**
     * 根据条件删除数据
     * @param array $condition
     * @return bool
     */
    public function delete(array $condition)
    {
        if(!is_array($condition) && empty($condition)){
            return false;
        }

        return $this->model->where($condition)->delete();
    }

    /**
     * @通过主键ID删除数据
     * @param $ids string|array
     * @return mixed
     */
    public function destroy($ids)
    {
        return $this->model->destroy($ids);
    }
}