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

    //查看公告跳转页面
    Route::get('/notice_show', 'User\AdminController@noticeShow');

    //跳转修改页面
    Route::get('/notice_mod', 'User\AdminController@noticeModShow');

    //调转到发布公告页面
    Route::get('/pub_show',function(){
        return view('user.index.pubnotice');
    });
    //公告发布
    Route::get('/pubNotice', 'User\AdminController@pubNotice');

    //公告删除
    Route::get('/delNotice', 'User\AdminController@delNotice');

    //公告修改
    Route::get('/modNotice', 'User\AdminController@modNotice');

    //显示历史公告
    Route::get('/noticeList', 'User\AdminController@noticeList');

    //游戏界面
    Route::get('/gameShow','User\GameController@gameShow');

    //大区增删查改
    //显示大区信息
    Route::get('/zoneShow','User\GameController@zoneShow');
    //删除大区信息
    Route::get('/delZone','User\GameController@delZone');
    //修改大区信息
    Route::get('/modZone','User\GameController@modZone');

    Route::group(['middleware'=>'check'],function(){


    });
});


