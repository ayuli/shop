<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\GoodsModel;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * 商品详情
     * @param $goods_id
     */
    public function index()
    {
        $goods = GoodsModel::all();

        //商品不存在
        if(empty($goods)){
            header('Refresh:2;url=/');
            echo '商品不存在,正在跳转至首页';
            exit;
        }

        $data = [
            'goods' => $goods
        ];
        return view('goods.index',$data);
    }
}
