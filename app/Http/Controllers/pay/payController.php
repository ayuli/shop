<?php

namespace App\Http\Controllers\pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderModel;
use App\Model\GoodsModel;

class payController extends Controller
{
    /**
     * 微信支付 NATIVE
     * appid: wxd5af665b240b75d4
     * mch_id: 1500086022
     *商户秘钥: 7c4a8d09ca3762af61e59520943AB26Q
     * strtoupper — 将字符串转化为大写
     */
    public function payTest($order_id)
    {
        $orderIdWhere = [
            'order_id'=>$order_id
        ];

        $order = OrderModel::where($orderIdWhere)->first();



        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $appid = 'wxd5af665b240b75d4';
        $mch_id = '1500086022';
        $str = md5(time());
//        $order_sn = date('YmdHi',time()).rand(1000,9999);
        $order_sn = $order['order_sn'];
        $ip = $_SERVER['REMOTE_ADDR']; //获取ip地址
        $notify_url = 'https://www.xiaomeinan.com/paynotify';  //异步回调
        $data = [
            'appid'     =>      $appid,
            'mch_id'    =>      $mch_id,
            'sign_type' =>      'MD5',
            'nonce_str' =>      $str,
            'body'      =>      '小小鱼的商品支付测试',
            'out_trade_no'=>    $order_sn,
            'total_fee' =>       1,    //用户要支付的总金额
            'spbill_create_ip'=> $ip,
            'notify_url'=>      $notify_url,
            'trade_type' =>     'NATIVE',
        ];

        //字典排序
        ksort($data);
        $paramsA = urldecode(http_build_query($data));
        $params=$paramsA.'&key=7c4a8d09ca3762af61e59520943AB26Q';
        $endStr = md5($params);
        $data['sign'] = strtoupper($endStr);  //转化为大写

        $obj = new \Url();
        $strJson = $obj->arr2Xml($data); //转化成 xml格式

        $info  = $obj->sendPost($url,$strJson); //发送
        $objxml = simplexml_load_string($info); //将xml转化成对象
        $url = $objxml->code_url;   //获取code
        return view('pay.pay',['url'=>$url]);
    }
    


}
