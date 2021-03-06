<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\GoodsModel;
use App\Model\CartModel;
use Illuminate\Support\Facades\Auth;
class IndexController extends Controller
{
    public $uid;

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function($request,$next){
            $this->uid =Auth::id();
            return $next($request);
        });
    }
    /** 购物车展示 */
    public function index(Request $request)
    {
        $cart_goods = CartModel::where(['uid'=>$this->uid])->get();

        if(empty($cart_goods)){
            echo "购物车是空的,请添加商品";
            header("refresh:3;url=/goods");
        }
        $cart = [
            'cart' => $cart_goods
        ];
        return view('cart.index',$cart);

    }

    /** 添加展示 */
    public function add($goods_id)
    {
        $goods = GoodsModel::where(['goods_id'=>$goods_id])->first();
        if(empty($goods)){
            header('Refresh:2;url=/');
            echo '商品不存在,正在跳转至首页';
            exit;
        }
        $data = [
            'goods' => $goods
        ];

        return view('cart.add',$data);
    }
    /**
     * 执行商品添加
     */
    public function addo(Request $request)
    {
        $goods_id = $request->input('goods_id');
        $num = $request->input('num');

        $goodsWhere = [
            'goods_id'=>$goods_id,
        ];
        //检查库存
        $store_num = GoodsModel::where($goodsWhere)->value('store');
//        print_r($store_num);die;
        if($store_num<=0&&$num>$store_num){
            $response = [
                'errno' => 5001,
                'msg'   => '库存不足'
            ];
            return $response;
        }
        $first = [
            'goods_id'=>$goods_id,
            'uid' => Auth::id()
        ];
        $CartModel = CartModel::where($first)->first();
        //重复 追加
        if(!empty($CartModel)){
            if($CartModel['num']+$num>$store_num){
                $response = [
                    'errno' => 5001,
                    'msg'   => '库存不足'
                ];
                return $response;
            }
            $data = [
                'num'       => $CartModel['num']+$num,
                'add_time'  => time(),
            ];
            $re = CartModel::where($goodsWhere)->update($data);
            if(!$re){
                $response = [
                    'errno' => 5002,
                    'msg'   => '添加购物车失败，请重试'
                ];
                return $response;
            }
            $response = [
                'errno' => 0,
                'msg'   => '添加成功'
            ];
            return $response;
        }
        $price = GoodsModel::where($goodsWhere)->value('price');
        //写入购物车表
        $data = [
            'goods_id'  => $goods_id,
            'num'       => $num,
            'price'     => $price,
            'add_time'  => time(),
            'uid'       => $this->uid,
            'session_token' => session()->get('u_token')
        ];

        $cid = CartModel::insertGetId($data);
        if(!$cid){
            $response = [
                'errno' => 5002,
                'msg'   => '添加购物车失败，请重试'
            ];
            return $response;
        }

        $response = [
            'errno' => 0,
            'msg'   => '添加成功'
        ];
        return $response;
    }

    /**
     * 删除购物车商品
     */
    public function del(Request $request)
    {
        $cart_id = $request->input('cart_id');
        //判断要删除的商品 是否在数据库
        $cartWhere = [
            'uid' => $this->uid,
            'id' => $cart_id
        ];
        $cart = CartModel::where($cartWhere)->first();
        if($cart){
            $re = CartModel::where($cartWhere)->delete();
            if(!$re){
                $response = [
                    'errno' => 5002,
                    'msg'   => '删除失败，请重试'
                ];
                return $response;
            }
        }else{
            $response = [
                'errno' => 5002,
                'msg'   => '操作有误,商品不在购物车中,请滚回去'
            ];
            return $response;
        }
        $response = [
            'errno' => 0,
            'msg'   => '删除成功'
        ];
        return $response;
    }




}
