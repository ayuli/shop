<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\GoodsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

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
        $redis_goods_key = 'h_goods_info';
        $goods_info = Redis::hGetAll($redis_goods_key);
        if($goods_info){
            echo 'Redis';echo '</br>';

            print_r($goods_info);
        }else{
            echo 'Mysql';
            $goods_info = GoodsModel::paginate(3);
            print_r($goods_info);die;
            //写入缓存
            $rs = Redis::hmset($redis_goods_key,$goods_info);
            //设置缓存过期时间
            Redis::expire($redis_goods_key,10);
        }

        die;


        //商品不存在
        if(empty($goods_info)){
            header('Refresh:2;url=/');
            echo '商品不存在,正在跳转至首页';
            exit;
        }

        $data = [
            'goods' => $goods_info
        ];
        return view('goods.index',$data);
    }

    /** 上传 */
    public function upload()
    {
        return view('goods.upload');
    }

    /**
     * @param Request $request
     * storeAs 文件上传时修改上传名
     */
    public function uploadPDF(Request $request)
    {

        $pdf = $request->file('pdf');
//        var_dump($pdf);die;
        $ext = $pdf->extension();
        if($ext != 'pdf'){
            die('请上传pdf格式的文件');
        }
        $res = $pdf->storeAs(date('Ymd'),str_random(5).'.pdf');
        if($res){
            echo "上传成功";
        }
    }
}
