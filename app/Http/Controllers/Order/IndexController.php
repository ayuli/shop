<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\CartModel;
use App\Model\GoodsModel;
use App\Model\OrderModel;

class IndexController extends Controller
{
    /** 订单展示 */
    public function index()
    {
        $order = OrderModel::where(['uid'=>session()->get('uid'),'is_delete'=>1])->get()->toArray();
        $data = [
            'order'=>$order
        ];
        return view('order.index',$data);
    }

    /**
     * 下单
     */
    public function add(Request $request)
    {

        // 接收order_id
        $cart_id = $request->input('cart_id');
        $order = rtrim($cart_id,',');
//        echo $order;die;
        if(substr_count($order,',')>=1){
            // 多少个商品结算 总价 多少个订单 删除多少个购物车数据
            $this->orderMore($order);
        }else{
            // 单个订单
            $this->orderSingle($order);
        }

        $response = [
            'errno' => 0,
            'msg'   => '下单成功'
        ];
        return $response;

    }
    /** 多个购物车商品订单 */
    public function orderMore($order){
        //查询购物车商品
        $orderArr = explode(',',$order);
        $order_amount_all = 0;
        foreach($orderArr as $v){
            $cart_goods = CartModel::where(['uid'=>session()->get('uid'),'id'=>$v])->first()->toArray();
            $order_amount = $cart_goods['num']*$cart_goods['price'];
            $order_amount_all += $cart_goods['num']*$cart_goods['price'];
//            echo $order_amount;
            $order_sn = OrderModel::OrderSN();
            $data = [
                'order_sn'      => $order_sn,
                'uid'           => session()->get('uid'),
                'goods_id'      => $cart_goods['goods_id'],
                'pay_num'       => $cart_goods['num'],
                'add_time'      => time(),
                'order_amount'  => $order_amount
            ];

            $oid = OrderModel::insertGetId($data);
            // 多个删除购物车数据
            CartModel::where(['id'=>$cart_goods['id']])->delete();

        }

    }
    /** 单个购物车商品订单 */
    public function orderSingle($order){
        //查询购物车商品
        $cart_goods = CartModel::where(['uid'=>session()->get('uid'),'id'=>$order])->first();
        if(empty($cart_goods)){
            die("购物车中无商品");
        }
        // 计算总价
        $order_amount = $cart_goods['num']*$cart_goods['price'];
//            echo $order_amount;
        //生成订单号
        $order_sn = OrderModel::OrderSN();

        // 生成订单
        $data = [
            'order_sn'      => $order_sn,
            'uid'           => session()->get('uid'),
            'pay_num'       => $cart_goods['num'],
            'add_time'      => time(),
            'order_amount'  => $order_amount,
            'goods_id'      =>$cart_goods['goods_id'],
        ];

        $oid = OrderModel::insertGetId($data);
        if(!$oid){
            $response = [
                'error' => 5002,
                'msg'   => '添加订单失败'
            ];
            return $response;
        }
        // 单个删除购物车数据
        CartModel::where(['id'=>$order])->delete();
    }
    /** 支付展示 */
    public function pay($order_id){
//        $order_id = $request->input('cart_id');
        $order = OrderModel::where(['order_id'=>$order_id])->first();
        $data = [
            'order'=>$order
        ];
        return view('order.pay',$data);
    }

    /** 支付执行 */
    public function payo($order_id)
    {
        // 减库存
        $orderWhere = [
            'order_id' => $order_id
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
        if($order['is_pay']==2){
            exit('已支付');
        }
        $orderData = [
            'pay_time'      =>  time(),
            'is_pay'        =>  2,
        ];
        OrderModel::where($orderWhere)->update($orderData);
        header('location:/order');
    }

    /** 取消订单 */
    public function off($order_id)
    {
        // 修改 is_delete 状态
        OrderModel::where(['order_id'=>$order_id])->update(['is_delete'=>2]);
        header('location:/order');
    }

    /** 退款 */
    public function refund()
    {
        // 把库存加回来

        //修改is_pay 状态为3 
    }
}
