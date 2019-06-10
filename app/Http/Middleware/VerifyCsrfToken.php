<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        "*"
//        "/pay/alipay/notify",
//        //微信公众号
//        'weixin/valid',
//        'weixin/valid1',
//        '/weixin/material',
//        //微信支付
//        '/weixin/pay/notice',
//        '/searchShow',
    ];
}
