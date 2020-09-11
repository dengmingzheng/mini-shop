<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use App\Services\AccountLogService;

class AccountLogServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * 在容器中注册绑定
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('AccountLogService', function () {
            return new AccountLogService();
        });
    }

    /**
     * 获取由提供者提供的服务
     *
     * @return array
     */
    public function provides() {
        return ['AccountLogService'];
    }
}


