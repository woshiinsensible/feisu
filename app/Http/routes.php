<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //上线改成post
    Route::get('/login', 'User\LoginController@login');

    Route::get('/test2', 'User\LoginController@test2');

    Route::get('/test','User\LoginController@test');

    Route::get('/proxyList', 'User\AdminController@proxyList');
    //充值记录列表
    Route::get('/rechargeList', 'User\AdminController@rechargeList');

    //上线改成post
    Route::get('/changePwd', 'User\AdminController@changePwd');
    Route::get('/change_pwd','User\AdminController@showPwd');

    //上线改成post
    Route::get('/changeCom', 'User\AdminController@changeCom');
    Route::get('/change_com','User\AdminController@showCom');

    Route::get('/changeSta', 'User\AdminController@changeSta');


    Route::get('/recharge', 'User\AdminController@recharge');
    Route::get('/rec_show', 'User\AdminController@recShow');

    //修改折扣
    Route::get('/changeDis', 'User\AdminController@changeDis');

    //显示提号记录
    Route::get('/pickupList', 'User\AdminController@pickupList');

    //显示历史公告
    Route::get('/noticeList', 'User\AdminController@noticeList');

    Route::group(['middleware'=>'check'],function(){


    });
});


