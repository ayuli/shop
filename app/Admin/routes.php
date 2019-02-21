<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/goods',GoodsController::class);
    $router->resource('/wxuser',WeixinController::class);   //微信用户管理
    $router->resource('/wxmedia',WeixinMediaController::class);    //微信素材管理

    $router->resource('/wxgroup',WeixinGroup::class);    //微信群发
    $router->post('/wxgroup','WeixinGroup@textGroup');    //微信群发
});
