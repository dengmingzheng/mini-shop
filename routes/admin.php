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

    Route::get('/logs', 'AccountController@logs');//后台日志列表

    /*网站管理模块*/
    Route::get('/banners', 'BannerController@index');//Banner列表
    Route::match(['get', 'post'], '/banners/create', 'BannerController@create');//添加Banner
    Route::match(['get', 'put'], '/banners/edit', 'BannerController@edit');//编辑Banner
    Route::delete('/banners/del', 'BannerController@del');//删除Banner

    Route::get('/douban', 'DouCategoryController@index');//豆瓣分类列表
    Route::match(['get', 'post'], '/douban/categories/create', 'DouCategoryController@createCategory');//添加豆瓣分类
    Route::match(['get', 'put'], '/douban/categories/edit', 'DouCategoryController@editCategory');//添加豆瓣分类
    Route::delete('/douban/categories/del', 'DouCategoryController@delCategory');//删除豆瓣分类

    Route::get('/douban/types', 'DouCategoryController@types');//豆瓣类型列表
    Route::match(['get', 'post'], '/douban/types/create', 'DouCategoryController@createType');//添加豆瓣类型
    Route::match(['get', 'put'], '/douban/types/edit', 'DouCategoryController@editType');//添加豆瓣类型
    Route::delete('/douban/types/del', 'DouCategoryController@delType');//删除豆瓣类型

    Route::get('/douban/tags', 'DouCategoryController@tags');//豆瓣标签列表
    Route::match(['get', 'post'], '/douban/tags/create', 'DouCategoryController@createTag');//添加豆瓣标签
    Route::match(['get', 'put'], '/douban/tags/edit', 'DouCategoryController@editTag');//添加豆瓣标签
    Route::delete('/douban/tags/del', 'DouCategoryController@delTag');//删除豆瓣标签

    Route::get('/douban/regions', 'DouCategoryController@regions');//豆瓣地区列表
    Route::match(['get', 'post'], '/douban/regions/create', 'DouCategoryController@createRegion');//添加豆瓣地区
    Route::match(['get', 'put'], '/douban/regions/edit', 'DouCategoryController@editRegion');//添加豆瓣地区
    Route::delete('/douban/regions/del', 'DouCategoryController@delRegion');//删除豆瓣地区

    Route::get('/douban/movies', 'DouMovieController@index');//豆瓣影视列表
    Route::match(['get', 'post'], '/douban/movies/create', 'DouMovieController@create');//添加豆瓣影视
    Route::match(['get', 'put'], '/douban/movies/edit', 'DouMovieController@edit');//添加豆瓣影视
    Route::delete('/douban/movies/del', 'DouMovieController@del');//删除豆瓣影视

    Route::get('/douban/comments', 'DouMovieController@comments');//豆瓣评论管理
    Route::get('/douban/comments/detail', 'DouMovieController@detail');//豆瓣评论详情
    Route::delete('/douban/comments/del', 'DouMovieController@delComment');//删除豆瓣评论
});