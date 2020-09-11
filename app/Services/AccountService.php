<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/11 0011
 * Time: 1:10
 */

namespace App\Services;

use App\Models\Account;

class AccountService extends BaseService
{
    public function init($uniqueKey = '', $uniqueValue = '', $idKey = 'id')
    {
        $this->initialize(new Account(), $uniqueKey, $uniqueValue, $idKey);
        return $this;
    }
}