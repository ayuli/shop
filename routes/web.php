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

//资源 路由组  group
//Route::middleware(['log.click'])->group(function(){
//    Route::any('/test/guzzle','Test\TestController@guzzleTest');
//    Route::get('/test/cookie1','Test\TestController@cookieTest1');
//    Route::get('/test/cookie2','Test\TestController@cookieTest2');
//    Route::get('/test/session','Test\TestController@sessionTest');
//    Route::get('/test/mid1','Test\TestController@mid1')->middleware('check.uid'
//    Route::get('/test/check_cookie','Test\TestController@checkCookie')->middlew
//});



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
Route::get('/cart','Cart\IndexController@index');
Route::get('/cart/add/{goods_id}','Cart\IndexController@add');
Route::post('/cart/add','Cart\IndexController@addo');      //添加商品
Route::post('/cart/del','Cart\IndexController@del');     //删除商品


// 商品表
//Route::get('/goods/{goods_id}','Goods\IndexController@index')->middleware('check.login.token');
Route::get('/goods','Goods\IndexController@index');


// 订单表
Route::get('/order','Order\IndexController@index');//->middleware('check.login.token');//订单展示
Route::post('/order/add','Order\IndexController@add');//->middleware('check.login.token');//添加订单
Route::get('/order/pay/{order_id}','Order\IndexController@pay');//->middleware('check.login.token');//支付展示
Route::get('/order/payo/{order_id}','Order\IndexController@payo');//->middleware('check.login.token');//执行支付
Route::get('/order/off/{order_id}','Order\IndexController@off');//->middleware('check.login.token');//取消订单
Route::get('/order/refund/{order_id}','Order\IndexController@refund');//->middleware('check.login.token');//取消订单


//支付
Route::get('/alipay/payo/{order_id}','Pay\AlipayController@payo');         //测试
//Route::get('/pay/alipay/test/{order_id}','Pay\AlipayController@test');         //测试
Route::post('/pay/alipay/notify','Pay\AlipayController@aliNotify');  // 异步
Route::get('/pay/alipay/return','Pay\AlipayController@aliReturn');   //支付宝支付 同步通知回调

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// 上传
Route::get('/upload','Goods\IndexController@upload');
Route::post('/goods/upload/pdf','Goods\IndexController@uploadPDF');


//redis 在线购票
Route::get('/movie','Movie\IndexController@index');
Route::get('/movie/buy/{pos}/{status}','Movie\IndexController@buy');


//微信
Route::get('/weixin/refresh_token','Weixin\WeixinController@refreshToken');     //刷新token
Route::get('/weixin/test/token','Weixin\WeixinController@test');
Route::get('/weixin/valid','Weixin\WeixinController@validToken');
Route::get('/weixin/valid1','Weixin\WeixinController@validToken1');
Route::post('/weixin/valid1','Weixin\WeixinController@wxEvent');        //接收微信服务器事件推送
Route::post('/weixin/valid','Weixin\WeixinController@validToken');

Route::get('/weixin/create_menu','Weixin\WeixinController@createMenu');     //创建菜单

Route::get('/weixin/mass','Weixin\WeixinController@textGroup');     //群发

Route::get('/form/show','Weixin\WeixinController@formShow');       //表单测试
Route::post('/form/test','Weixin\WeixinController@formTest');   //表单测试

Route::get('/weixin/material/list','Weixin\WeixinController@materialList');     //获取永久素材列表
Route::get('/weixin/material/upload','Weixin\WeixinController@upMaterial');     //上传永久素材
Route::post('/weixin/material','Weixin\WeixinController@materialTest');     //

//Route::get('/weixin/interactive/form','Weixin\WeixinController@interactiveForm');     //客服展示
Route::post('/weixin/write','Weixin\WeixinController@write');     //客服发送

//微信聊天
Route::get('/weixin/kefu/chat','Weixin\WeixinController@chatView');     //客服聊天
Route::get('/weixin/chat/get_msg','Weixin\WeixinController@getChatMsg');     //获取用户聊天信息

//微信支付
Route::get('/weixin/pay/test/{order_id}','Weixin\PayController@test');  //微信支付测试
Route::post('/weixin/pay/notice','Weixin\PayController@notice');   //微信支付通知回调
Route::get('/weixin/pay/wx_uccess/{order_id}','Weixin\PayController@wx_uccess');   //微信支付通知回调

//微信登陆测试
Route::get('/weixin/login','Weixin\WeixinController@login');
Route::get('/weixin/getcode','Weixin\WeixinController@getCode'); //接收code

