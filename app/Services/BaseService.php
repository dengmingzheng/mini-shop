<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/11 0011
 * Time: 1:10
 */

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use RedisService;

class BaseService
{

    /**
     * Eloquentmo模型
     * @var Model
     */
    public $model;

    /**
     * 主键名
     * @var string
     */
    public $idKey;

    /**
     * 唯一标识键名
     * @var string
     */
    public $uniqueKey;

    /**
     * 唯一标识值
     * @var string
     */
    public $uniqueValue;

    /**
     * 查询关联关系数组
     * @var array
     */
    public $with;

    /**
     * 所有关联关系，插入redis时使用
     * @var array
     */
    public $withAll;

    /**
     * 排序字符串
     * @var string
     */
    public $order;

    /**
     * 排序
     * @var string
     */
    public $sort;

    /**
     * 每页显示的条数
     * @var number
     */
    public $perPage=15;

    /**
     * 查询字段
     * @var array
     */
    public $field;

    /**
     * 查询条件
     * @var array
     */
    public $where = [];

    /**
     * 忽略查询条件强制读取redis数据
     * @var array
     */
    public $whereIgnore;

    /**
     * 表名
     * @var string
     */
    public $tableName;

    public $redis;

    /**
     * 初始化 设置唯一标识和redis键名
     * @param $model [模型实例]
     * @param string $uniqueKey [唯一键名]
     * @param string $uniqueValue [唯一键值]
     * @param string $idKey [主键名]
     * @param array $ignore
     */
    public function initialize($model, $uniqueKey = '', $uniqueValue = '', $idKey = 'id', $ignore = [])
    {
        //设置属性
        $this->model = $model;
        $this->uniqueKey = $uniqueKey;
        $this->uniqueValue = $uniqueValue;
        $this->idKey = $idKey;
        $this->order = $idKey;
        $this->sort = 'DESC';

        /* 获取表名 */
        $tableName = $model->getTable();

        // 设置强制忽略查询条件数组
        if ( !empty($ignore) ) {
            $this->whereIgnore($ignore);
        }

        /* 设置redis键名 */
        if ( !empty($uniqueKey) && !empty($uniqueValue) ) {
            if ( !empty($ignore) ) {
                $uniqueKey .= '_';
                foreach ($ignore as $key => $value) {
                    $uniqueKey .= $key . '_' . $value;
                }
            }
            $uniqueKey = ':' . $uniqueKey . ':' . $uniqueValue;
        } else {
            $uniqueKey = '';
        }
        $redisListKey = $tableName . $uniqueKey;//list列表键名
        $redisHashKey = $tableName . ':' . $idKey . ':';//hash键值

        RedisService::key([ $redisListKey, $redisHashKey ], $idKey);

    }

    /**
     * 列表查询
     *
     * @param  boolean $pageFlag [是否分页]
     * @param  array   $idList   [查询指定主键的数据]
     * @return array             [数据和分页]
     */
    public function getList($pageFlag = true, $idList = [])
    {
        /* 接收参数 */
        $input = app('request')->input();

        /* 读取配置文件中的每页多少条数据参数 */
        $this->perPageJudge();

        /* 数据和分页 */
        $list     = [];
        $pageHtml = '';
        /* redis里没有任何数据 则将所有主键存入redis */
        $this->redisEmptyJudge();

        // 有强制忽略则将查询条件置空
        if ( !empty($this->whereIgnore) ) {
            $this->where = [];
        }

        /* 查询条件为空则读取redis数据 否则查询数据库 */
        if ( empty($this->where) ) {             /* redis分页 */
            if ( $pageFlag === false ) {
                if ( empty($idList) ) {

                    list($list, $pageHtml, $inexistenceIds) = RedisService::getList();
                } else {

                    list($list, $pageHtml, $inexistenceIds) = RedisService::getList(0, -1, $idList);
                }
            } else {

                list($list, $pageHtml, $inexistenceIds) = RedisService::page();
            }

            /* 查询没有缓存的数据 */
            if (!empty($inexistenceIds) ) {

                /* 查询数据库 */
                $inexistenceList = $this->model->select($this->getField())->whereIn($this->idKey, $inexistenceIds)->orderBy($this->order,$this->sort)->get();
                if ( $this->withAll ) {
                    foreach ($this->withAll as $wv) {
                        $inexistenceList->load($wv);
                    }
                }
                $inexistenceList = $inexistenceList->toArray();

                /* 将数据写入redis */
                if ( !empty($this->withAll) ) {
                    RedisService::update(function () use (&$inexistenceList) {
                        foreach ($inexistenceList as $key => $value) {
                            foreach ($this->withAll as $wev) {
                                if ( isset($value[$wev]) && is_array($value[$wev]) ) {
                                    $inexistenceList[$key][$wev] = json_encode($value[$wev]);
                                }
                            }
                        }
                        return $inexistenceList;
                    });
                } else {

                    RedisService::update($inexistenceList);
                }

                /* 合并数组 */
                $list['data'] = array_merge($list['data'], $inexistenceList);

            }

        } else {

            /* 组装唯一标识并加入查询条件 */
            if ( !empty($this->uniqueKey) && !empty($this->uniqueValue) && empty($this->where[$this->uniqueKey]) ) {
                $this->where[$this->uniqueKey] = $this->uniqueValue;
            }

            /* 查询指定id */
            if ( count($idList) ) {
                $this->where[$this->idKey] = ['in', $idList];
            }

            /* 查询数据库并分页 */
            if ( $this->with ) {
                $list = $this->model->select($this->getField())->where($this->where)->orderBy($this->order,$this->sort);
                if ( $pageFlag === false ) {
                    $list = $list->get();
                    $pageHtml = '';
                } else {
                    $list = $list->paginate($this->perPage)->appends($input);
                    $pageHtml = $list->links();
                }
                foreach ($this->with as $wv) {
                    $list->load($wv);
                }

            } else {
                if ( $pageFlag === false ) {
                    $list = $this->model->select($this->getField())->where($this->where)->orderBy($this->order,$this->sort)->get();
                    $pageHtml = '';
                } else {
                    $list = $this->model->select($this->getField())->where($this->where)->orderBy($this->order,$this->sort)->paginate($this->perPage)->appends($input);
                    $pageHtml = $list->links();
                }
            }
            /* 转化整个模型集合为数组 */
            $list = $list->toArray();

        }

        /* 解析数据 */
        if ( isset($list['data']) && !empty($this->withAll) ) {

            foreach ($list['data'] as $k => $v) {
                foreach ($this->withAll as $wev) {
                    if ( isset($v[$wev]) && !is_array($v[$wev]) ) {
                        $list['data'][$k][$wev] = json_decode($v[$wev], true);
                    }
                }
            }
        } elseif ( !isset($list['data']) ) {

            $temp['data'] = $list;
            $list = $temp;
            unset($temp);
        }

        return [ $list, $pageHtml ];
    }

    /**
     * 单条数据查询
     * 1、读取redis数据
     * 2、第一步失败则查数据库并写入redis
     *
     * @param  integer $id [主键值]
     * @return array       [查询结果]
     */
    public function getInfo($id = -1)
    {
        if (empty($this->where)) {

            if (RedisService::exists($id)) {
                // redis中存在该键 获取单条数据
                $info = RedisService::getInfo($id);

                if (empty($info)) {
                    // 查询数据库
                    if (empty($this->withAll)) {
                        $info = $this->model->select($this->getField())->find($id);
                    } else {
                        $info = $this->model->select($this->getField())->with($this->withAll)->find($id);
                    }
                    if (!empty($info)) {
                        $info = $info->toArray();
                        $redisDatas = $info;
                        // 数据处理
                        if (!empty($this->withAll)) {
                            foreach ($this->withAll as $value) {
                                if (isset($redisDatas[$value]) && is_array($redisDatas[$value])) {
                                    $redisDatas[$value] = json_encode($redisDatas[$value]);
                                }
                            }
                        }
                        // 将数据写入redis
                        RedisService::update($redisDatas);
                    } else {
                        return [];
                    }
                } else {
                    // 数据处理
                    if (!empty($this->withAll)) {

                        foreach ($this->withAll as $value) {
                            if (isset($info[$value])) {
                                $info[$value] = json_decode($info[$value], true);
                            }
                        }
                    }

                }
            } else {
                // redis里没有对应键值 则查询数据库
                if (empty($this->withAll)) {
                    $info = $this->model->select($this->getField())->find($id);
                } else {
                    $info = $this->model->select($this->getField())->with($this->withAll)->find($id);
                }

                if (!empty($info)) {
                    // redis里没有任何数据 则将所有主键存入redis
                    $this->redisEmptyJudge();

                    $info = $info->toArray();
                    $redisDatas = $info;
                } else {
                    return [];
                }

                // 数据处理
                if (!empty($this->withAll)) {
                    foreach ($this->withAll as $value) {
                        if (isset($redisDatas[$value]) && is_array($redisDatas[$value])) {
                            $redisDatas[$value] = json_encode($redisDatas[$value]);
                        }
                    }
                }

                RedisService::update([$redisDatas]);
            }
        } else {

            $info = $this->model->select($this->getField())->where($this->where)->first();

            if (!empty($info)) {
                $info = $info->toArray();
            } else {
                return [];
            }
        }


        return $info;
    }

    /**
     * 插入数据库 并返回主键
     * @param  array  $data [要插入的数据]
     */
    public function addD($data)
    {
        return $this->model->insertGetId($data);
    }

    /**
     * 插入redis
     * @param  array  $data [要插入的数据]
     */
    public function addR($data)
    {
        if ( !empty($this->withAll) ) {
            foreach ($this->withAll as $value) {
                if ( isset($data[$value]) && is_array($data[$value]) ) {
                    $data[$value] = json_encode($data[$value]);
                }
            }
        }

        RedisService::save([$data]);

        return true;
    }

    public function add($datas) {

        if ( is_array(current($datas)) ) {
            // batch 事务没写！！！
            $datas = array_values($datas);
            foreach ($datas as $key => $value) {
                $id[$key] = $this->model->insertGetId($value);
                if ( $id[$key] === false ) {
                    return $key;
                }
            }
            $query = $this->model->whereIn($this->idKey, $id)->get();
        } else {
            // only one
            $id = $this->model->insertGetId($datas);
            if ( $id === false ) {
                return false;
            }
            $query = $this->model->where($this->idKey, $id)->get();
        }

        if ( !empty($this->withAll) ) {
            foreach ($this->withAll as $val) {
                $query->load($val);
            }
        }
        $redisDatas = $query->toArray();

        foreach ($redisDatas as $k => $val) {
            if ( !empty($this->withAll) ) {
                foreach ($this->withAll as $v) {
                    if ( !isset($redisDatas[$k][$v]) ) {
                        $redisDatas[$k][$v] = json_encode([]);
                    } else {
                        $redisDatas[$k][$v] = json_encode($redisDatas[$k][$v]);
                    }
                }
            }
        }
        // 插入redis
        RedisService::save($redisDatas);

        return $id;
    }

    /**
     * 更新redis缓存数据
     * 支持多条更新和单条更新
     * 多条记录更新需要把所有字段传入
     * 防止失误更新整表 必须加条件更新
     *
     * @param  array  $datas [要更新的数据数组]
     *
     * @return boolean [成功true，失败false]
     *
     */
    public function update($datas)
    {
        if ( is_array(current($datas)) ) {
            // batch
            foreach ($datas as $key => $value) {
                $save = $this->model->where($this->where)->update($value);
                if ( !$save ) {
                    return false;
                }
                if ( !empty($this->withAll) ) {
                    foreach ($this->withAll as $wev) {
                        if ( isset($value[$wev]) && is_array($value[$wev]) ) {
                            $datas[$key][$wev] = json_encode($value[$wev]);
                        }
                    }
                }
            }
            $redisDatas = $datas;
            $redisField = [];
        } else {
            // only one
            if ( empty($this->where) ) {
                // 防止失误更新整表 必须加条件更新
                return false;
            }
            $save = $this->model->where($this->where)->update($datas);
            if ( !$save ) {
                return false;
            }
            if ( !empty($this->withAll) ) {
                foreach ($this->withAll as $wev) {
                    if ( isset($datas[$wev]) && is_array($datas[$wev]) ) {
                        $datas[$wev] = json_encode($datas[$wev]);
                    }
                }
            }
            $redisDatas = isset($this->where[$this->idKey]) ? $this->where[$this->idKey] : $datas[$this->idKey];
            $redisField = $datas;
        }

        if ( $save ) {
            // 更新redis
            RedisService::update($redisDatas, $redisField);

            return true;
        }

        return false;
    }

    /**
     * 更新数据库，仅支持单条记录更新
     * @param  array  $datas     [要更新的数据数组]
     * @return boolean [更新成功则返回true，更新失败返回false]
     */
    public function updateD($datas)
    {
        // 防止失误更新整表 必须加条件更新
        if ( empty($this->where) ) {
            return false;
        }

        return  $dbResult = $this->model->where($this->where)->update($datas);
    }

    /**
     * 设置查询字段
     *
     * @param  array|mixed  $columns [字段名]
     *
     * @return $this
     */
    public function getField()
    {
        if ( empty($this->field) ) {
            $this->field = $this->getAllColumn();
        }

        return $this->field;
    }


    /**
     * 获取表所有字段
     * @return array             [表所有字段]
     *
     */
    public function getAllColumn()
    {
        $this->field = Schema::getColumnListing($this->model->getTable());

        return $this->field;
    }

    /**
     * 设置查询条件
     * @param  array  $where [条件数组]
     *
     * @return $this
     */
    public function where(array $where)
    {
        $this->where = $where;

        return $this;
    }

    /**
     * 设置排序字符串
     * @param  string  $order [排序字符串]
     *
     * @return $this
     */
    public function orderBy($order,$sort)
    {
        $this->order = $order;
        $this->sort = $sort;

        return $this;
    }

    /**
     * 设置关联关系
     *
     * @param  array $with [关联关系名称]
     *
     * @return $this
     */
    public function with($with)
    {
        $this->with = $with;

        return $this;
    }

    /**
     * 查询前页数判断
     * 已设置则知道redis页数
     * 未设置则读取配置文件中的每页多少条数据参数（redis默认也会读取配置文件中的每页多少条数据参数，故不需要再单独设置）
     *
     * @return $this
     */
    public function perPageJudge()
    {
        if ($this->perPage) {
            RedisService::per($this->perPage);
        } else {
            $this->perPage = config('database')['perPage'];
        }

        return $this;
    }

    /**
     * redis数据为空的情况处理
     *
     * redis里没有任何数据 则将所有主键存入redis
     * 否则不进行任何操作
     *
     * @return $this
     */
    public function redisEmptyJudge()
    {
        if ( !RedisService::count() ) {
            $wherePush = [];
            if ( !empty($this->whereIgnore) ) {
                $wherePush = $this->whereIgnore;
            }
            if ( !empty($this->uniqueKey) && !empty($this->uniqueValue) && empty($wherePush[$this->uniqueKey]) ) {
                $wherePush[$this->uniqueKey] = $this->uniqueValue;
            }
            $this->model->select([$this->idKey])->where($wherePush)->orderBy($this->order,$this->sort)->chunk(100, function($totalIds) {
                RedisService::push($totalIds);
            });
        }

        return $this;
    }

    /**
     * 设置强制忽略查询条件数组
     *
     *
     * @param  array $where [条件数组]
     *
     * @return $this
     */
    public function whereIgnore(array $where)
    {
        $this->whereIgnore = $where;

        return $this;
    }
}