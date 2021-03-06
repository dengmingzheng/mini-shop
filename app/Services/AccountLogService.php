<?php

namespace App\Services;

class AccountLogService extends BaseService
{
    public $model;

    public function __construct()
    {
        parent::__construct('AccountLog');
    }

    //写入日志
    public function write($content, $data = [])
    {
        $insertData = [
            'account_id' => request()->session()->get('accountData')['id'],
            'username'=>request()->session()->get('accountData')['username'],
            'content' => $content,
            'data' =>json_encode($data),
            'ip'=>request()->getClientIp(),
            'updated_at' => get_current_time(),
            'created_at' => get_current_time(),
        ];

        return $this->add($insertData);
    }

}