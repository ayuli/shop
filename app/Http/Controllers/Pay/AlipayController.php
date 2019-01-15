<?php

namespace App\Http\Controllers\Pay;

use App\Model\OrderModel;
use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;

class AlipayController extends Controller
{

    public $app_id;    //APPID
    public $gate_way;  //跳转地址
    public $notify_url;  // 异步回调地址
    public $return_url;    //  同步回调地址
    public $rsaPrivateKeyFilePath = './key/priv.key'; //私钥目录
    public $aliPubKey = './key/ali_pub.key';


    public function __construct()
    {
        $this->app_id=env('ALIPAY_APP_ID');
        $this->gate_way=env('ALIPAY_GATE_WAY');
        $this->notify_url=env('ALIPAY_NOTILY_URL');
        $this->return_url = env('ALIPAY_RETURN_URL');

    }

    /** 请求订单服务 处理订单逻辑 */
    public function payo($order_id)
    {
//        echo $order_id;die;
        $orderWhere = [
            'order_id' => $order_id
        ];
        $order = OrderModel::where($orderWhere)->first()->toArray();
        // 验证 订单是否存在
        if(empty($order)){
            die('订单不存在!');
        }
        // 验证 订单是否支付 已过期 已删除
        if($order['pay_time']>0){
            die('此订单已被支付，无法再次支付');
        }
        if($order['is_delete']==2){
            die('此订单已被删除，无法再次支付');
        }

        // 业务参数
        $bizcont = [
            'subject'       => 'yyyyyy',
            'out_trade_no'      => $order_id,
            'total_amount'      => $order['order_amount'],
            'product_code'      => 'QUICK_WAP_WAY',
        ];
//        print_r($bizcont);die;
        //公共参数
        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.wap.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,        //异步通知地址
            'return_url'   => $this->return_url,        // 同步通知地址
            'biz_content'   => json_encode($bizcont),
        ];
        //签名
        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;
        header("Location:".$url);

    }

    public function test()
    {
        $bizcont = [
            'subject'           => 'yyyyyy',
            'out_trade_no'      => 'oid'.date('YmdHis').mt_rand(1111,2222),
            'total_amount'      => 1,
            'product_code'      => 'QUICK_WAP_WAY',

        ];

        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.wap.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,
            'return_url'   =>$this->return_url,
            'biz_content'   => json_encode($bizcont),
        ];

        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }
        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;
        header("Location:".$url);
    }


    public function rsaSign($params) {
        return $this->sign($this->getSignContent($params));
    }

    protected function sign($data) {

        $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
        $res = openssl_get_privatekey($priKey);
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);

        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }


    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }

        unset ($k, $v);
        return $stringToBeSigned;
    }

    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }


    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {

        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }


        return $data;
    }


    /**
     * 支付宝同步通知回调
     */
    public function aliReturn()
    {
//        print_r($_POST);
        echo '</pre>';print_r($_GET);echo '</pre>';
        echo "订单:".$_GET['out_trade_no']."支付成功";
        echo "支付金额为:".$_GET['total_amount'];
        //验签 支付宝的公钥
//        if(!$this->verify()){
//            echo 'error';
//        }

        //处理订单逻辑
//        $this->dealOrder($_GET);
    }

    /**
     * 支付宝异步通知
     */
    public function aliNotify()
    {

        $data = json_encode($_POST);
        $log_str = '>>>> '.date('Y-m-d H:i:s') . $data . "<<<<\n\n";
        //记录日志
        file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);


        //验签
        $res = $this->verify($_POST);
        $log_str = '>>>> ' . date('Y-m-d H:i:s');

        if($res === false){
            //记录日志 验签失败
            $log_str .= " Sign Failed!<<<<< \n\n";
            file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
        }else{
            $log_str .= " Sign OK!<<<<< \n\n";
            file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
        }


        //处理订单逻辑
        $this->dealOrder($_POST);

        echo 'success';
    }

    //验签
    function verify($params) {
        $sign = $params['sign'];
        $params['sign_type'] = null;
        $params['sign'] = null;

        //读取公钥文件
        $pubKey = file_get_contents($this->aliPubKey);
        $pubKey = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        //转换为openssl格式密钥

        $res = openssl_get_publickey($pubKey);
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');

        //调用openssl内置方法验签，返回bool值

        $result = (openssl_verify($this->getSignContent($params), base64_decode($sign), $res, OPENSSL_ALGO_SHA256)===1);
        openssl_free_key($res);

        return $result;
    }

    /**
     * 处理订单逻辑 更新订单 支付状态 更新订单支付金额 支付时间
     * @param $data
     */
    public function dealOrder($_POST)
    {
        // 减库存
        $orderWhere = [
            'order_id' => $_POST['out_trade_no']
        ];
        $order = OrderModel::where($orderWhere)->first()->toArray();
        $goodsWhere = [
            'goods_id' =>$order['goods_id']
        ];
        $goods = GoodsModel::where($goodsWhere)->first();
        $goodsData = [
            'store' => $goods['store']-$order['pay_num']
        ];
        if($goodsData<=0){
            exit('库存不足');
        }
        GoodsModel::where($goodsWhere)->update($goodsData);

        // 修改订单状态

        $orderData = [
            'pay_amount'   => $_POST['total_amount'],
            'pay_time'      =>  time(),
            'is_pay'        =>  2,   //1未支付  2 已支付
            'plat'          => 1, // 平台编号 1 支付宝 2 微信
        ];
        OrderModel::where($orderWhere)->update($orderData);


    }
}
