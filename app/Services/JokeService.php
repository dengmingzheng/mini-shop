<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/20 0020
 * Time: 11:52
 */

namespace App\Services;

use App\Models\Joke;

class JokeService extends BaseService
{
    public function init($uniqueKey = '', $uniqueValue = '', $idKey = 'id')
    {
        $this->initialize(new Joke(), $uniqueKey, $uniqueValue, $idKey);
        return $this;
    }
}