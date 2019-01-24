<?php

namespace App\Http\Controllers\Movie;

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
     * 订座页面 显示所有座位及订座状态
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $key = 'test_bit';

        $seat_sattus = [];
        for($i=0;$i<=31;$i++){
            $status = Redis::getBit($key,$i);
//            var_dump($status);echo '</br>';
            $seat_sattus[$i] = $status;
        }

        $data = [
            'seat' => $seat_sattus
        ];
        return  view('movie.index',$data);
    }
    // 买票
    public function buy($pos,$status){
        $key = 'test_bit';
        Redis::setbit($key,$pos,1);
        echo '购票成功';
        header('refresh:2;url=/movie');
    }

}
