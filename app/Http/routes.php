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

    /**********************游戏界面***********************/
    Route::get('/gameShow','User\GameController@gameShow');

    //大区增删查改
    //显示大区信息
    Route::get('/zoneShow','User\GameController@zoneShow');

    //删除大区信息
    Route::get('/delZone','User\GameController@delZone');

    //显示大区页面
    Route::get('/modZoneShow','User\GameController@modZoneShow');

    //修改大区信息
    Route::get('/modZone','User\GameController@modZone');

    //跳转到添加大区页面
    Route::get('/addZoneShow',function(){
        return view('user.game1.addzone');
    });

    //添加大区
    Route::get('/addZone','User\GameController@addZone');

    //账号定价列表显示
    Route::get('/priceShow','User\GameController@priceShow');

    //跳转价格修改页面
    Route::get('/modPriceShow','User\GameController@modPriceShow');

    //修改账号价格
    Route::get('/modPrice','User\GameController@modPrice');

    //跳转到添加账号价格
    Route::get('/addPriceShow',function(){
        return view('user.game1.addprice');
    });

    //添加账号价格
    Route::get('/addPrice','User\GameController@addPrice');

    //excel
    Route::post('/readExcel','User\GameController@readExcel');

    //显示账号列表
    Route::get('/bankShow','User\GameController@bankShow');

    //更新组合账号的价格
    Route::get('/updatePrice','User\GameController@updatePrice');

    //单个删除组合账号
    Route::get('/delSingle','User\GameController@delSingle');

    //批量删除组合账号
    Route::get('/delBatch','User\GameController@delBatch');

    //跳转组合账号修改页面
    Route::get('/modGroupShow','User\GameController@modGroupShow');

    //修改组合账号
    Route::get('/modGroup','User\GameController@modGroup');

    //调转到上传组合账号页面
    Route::get('/uploadShow','User\GameController@uploadShow');

    //批量上传组合账号
    Route::post('/upload','User\GameController@upload');


    Route::group(['middleware'=>'check'],function(){


    });
});


