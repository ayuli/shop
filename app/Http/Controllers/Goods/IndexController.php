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
        $goods = GoodsModel::paginate(3);

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
