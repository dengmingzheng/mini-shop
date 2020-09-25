<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace'=>'Api'],function(){
    Route::group(['namespace'=>'V1','prefix'=>'v1'],function(){
        Route::get('test','BannerController@test');
        Route::get('jokes','JokeController@index');

        Route::get('movies','DouMovieController@movieList');//影视列表
        Route::get('movie','DouMovieController@detail');//影视详细数据
        Route::get('comments','DouMovieController@comments');//评论列表
    });

});
