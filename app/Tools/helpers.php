<?php
use Carbon\Carbon;

//提示信息
if (!function_exists('showMessage')) {

    function showMessage($msg, $url = '') {

        return response()->view('system.layout.layout_error', ['message' => $msg, 'url' => $url]);
    }
}

//获取当前时间
if (!function_exists('get_current_time')) {

    function get_current_time() {

        return Carbon::now()->toArray()['formatted'];
    }
}