<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use App\Services\RedisService;

class RedisServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('RedisService', function ($app) {
            return new RedisService($app['config']['database.perPage']);
        });
    }

    /**
     * 获取由提供者提供的服务
     *
     * @return array
     */
    public function provides() {
        return ['RedisService'];
    }
}
