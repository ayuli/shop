<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/adduser','User\UserController@add');

//路由跳转
Route::redirect('/hello1','/world1',301);
Route::get('/world','Test\TestController@world1');

Route::get('hello2','Test\TestController@hello2');
Route::get('world2','Test\TestController@world2');


//路由参数
Route::get('/user/test','User\UserController@test');
//Route::get('/user/{uid}','User\UserController@user');
Route::get('/month/{m}/date/{d}','Test\TestController@md');
Route::get('/name/{str?}','Test\TestController@showName');



// View视图路由
Route::view('/mvc','mvc');
Route::view('/error','error',['code'=>40300]);


// Query Builder
Route::get('/query/get','Test\TestController@query1');
Route::get('/query/where','Test\TestController@query2');


//Route::match(['get','post'],'/test/abc','Test\TestController@abc');
Route::any('/test/abc','Test\TestController@abc');


Route::get('/view/test1','Test\TestController@viewTest1');
Route::get('/view/test2','Test\TestController@viewTest2');




//用户注册
Route::get('/user/reg','User\UserController@reg');
Route::post('/user/reg','User\UserController@doReg');

Route::get('/user/login','User\UserController@login');           //用户登录
Route::post('/user/login','User\UserController@doLogin');        //用户登录
Route::get('/user/center','User\UserController@center');        //个人中心


//模板引入静态文件
Route::get('/mvc/test1','Mvc\MvcController@test1');

Route::get('/mvc/bst','Mvc\MvcController@bst');

//退出
Route::get('user/quit','User\UserController@quit');

//购物车
//Route::get('/cart','Cart\IndexController@index')->middleware('check.uid');
Route::get('/cart','Cart\IndexController@index')->middleware('check.login.token');
Route::get('/cart/add/{goods_id}','Cart\IndexController@add')->middleware('check.login.token');
Route::post('/cart/add','Cart\IndexController@addo')->middleware('check.login.token');      //添加商品
Route::post('/cart/del','Cart\IndexController@del')->middleware('check.login.token');      //删除商品


// 商品表
//Route::get('/goods/{goods_id}','Goods\IndexController@index')->middleware('check.login.token');
Route::get('/goods','Goods\IndexController@index');


// 订单表
Route::get('/order','Order\IndexController@index')->middleware('check.login.token');//订单展示
Route::post('/order/add','Order\IndexController@add')->middleware('check.login.token');//添加订单
Route::get('/order/pay/{order_id}','Order\IndexController@pay')->middleware('check.login.token');//支付展示
Route::get('/order/payo/{order_id}','Order\IndexController@payo')->middleware('check.login.token');//执行支付
Route::get('/order/off/{order_id}','Order\IndexController@off')->middleware('check.login.token');//取消订单
Route::get('/order/refund/{order_id}','Order\IndexController@refund')->middleware('check.login.token');//取消订单


//支付
Route::get('/pay/alipay/test','Pay\AlipayController@test');         //测试
Route::get('/pay/alipay/notify','Pay\AlipayController@notify');  //回调
