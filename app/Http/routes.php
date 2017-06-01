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

    //获取信息插入表7
    Route::get('/getInfo', 'Other\HandleController@getInfo');
    //info index
    Route::get('/info ',function(){
        return view('user.other.info');
    });


    //testexcel
    Route::get('/testexcel', 'User\GameController@testexcel');

    //首页
    Route::get('/index ',function(){
        return view('user.index');
    });

    Route::get('/test2/{tmp}', 'User\LoginController@test2');

    Route::get('/test','User\LoginController@test');

    //上线改成post
    Route::get('/login', 'User\LoginController@login');




    Route::group(['middleware'=>'check'],function(){

        Route::get('/proxyList', 'User\AdminController@proxyList');
        //充值记录列表
        Route::get('/rechargeList', 'User\AdminController@rechargeList');

        //退出账号
        Route::get('/logout', 'User\AdminController@logout');
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

        //代理用户注册
        Route::get('/loginProxy', 'User\AdminController@loginProxy');

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

        //修改游戏销售状态
        Route::get('/changeSell', 'User\GameController@changeSell');

        //修改价格显示状态
        Route::get('/changePrice', 'User\GameController@changePrice');

        //代理用户后台界面
        Route::get('/proxyIndex', 'User\ProxyController@proxyIndex');

        //代理用户查看一条公告showNotice
        Route::get('/showNotice', 'User\ProxyController@showNotice');

        //获取代理用户充值记录
        Route::get('/rechargeRecode', 'User\ProxyController@rechargeRecode');

        //账号提取
        Route::get('/pickShow', 'User\PgameController@pickShow');

        //跳转执行提号动作
        Route::get('/pickup', 'User\PgameController@pickup');

        //确认购买账号
        Route::get('/buy', 'User\PgameController@buy');

        //提货记录
        Route::get('/pickRecode', 'User\PgameController@pickRecode');

        //调转到注册代理用户页面
        Route::get('/loginproxy',function(){
            return view('user.index.loginproxy');
        });

        //判断代理用户是否存在
        Route::get('/prouserExist', 'User\AdminController@prouserExist');

        //执行注册代理用户动作
        Route::get('/loginProxyUser', 'User\AdminController@loginProxyUser');

        //查询代理的信息
        Route::get('/findProxyList', 'User\FindController@findProxyList');

        //查询提号记录pickupList
        Route::get('/findPickupList', 'User\FindController@findPickupList');

        //查询充值记录findRechargeList
        Route::get('/findRechargeList', 'User\FindController@findRechargeList');

    });
});


