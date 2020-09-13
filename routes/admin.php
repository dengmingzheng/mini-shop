<?php

//后台登录路由
Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){
    Route::get('/','LoginController@showLoginForm');
    Route::get('/login','LoginController@showLoginForm');
    Route::post('/login','LoginController@login');
    Route::get('logout','LoginController@logout');
});

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['admin.auth','admin.permission']],function(){
    /*系统管理模块*/
    Route::get('/menus', 'MenuController@index');//菜单列表
    Route::match(['get', 'post'], '/menus/create', 'MenuController@create');//添加菜单
    Route::match(['get', 'put'], '/menus/edit', 'MenuController@edit');//编辑菜单
    Route::delete('/menus/del', 'MenuController@del');//删除菜单

    /*网站管理模块*/
    Route::get('/banners', 'BannerController@index');//Banner列表
    Route::match(['get', 'post'], '/banners/create', 'BannerController@create');//添加Banner
    Route::match(['get', 'put'], '/banners/edit', 'BannerController@edit');//编辑Banner
    Route::delete('/banners/del', 'BannerController@del');//删除Banner
});