<?php

namespace App\Services;
use App\Models\AccountLog;

class AccountLogService extends BaseService
{
    public $model;

    public function __construct()
    {
        $this->model = new AccountLog();
    }

    //写入日志
    public function write($content, $data = [])
    {
        $insertData = [
            'account_id' => request()->session()->get('accountData')['id'],
            'content' => $content,
            'data' =>json_encode($data),
            'ip'=>request()->getClientIp(),
            'updated_at' => get_current_time(),
            'created_at' => get_current_time(),
        ];

        return $this->model->insertGetId($insertData);
    }

}