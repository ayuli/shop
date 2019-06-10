<?php

namespace App\Http\Controllers\User;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\UserModel;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function center(Request $request)
    {

//            echo 'UID: '.$_COOKIE['uid'] . ' 欢迎回来';
            $list = UserModel::all();
            $data = [
                'list'=>$list,
            ];
            return view('users.show',$data);

    }

    /** 退出 */
    public function quit(){
        Auth::logout();
//        session()->pull('u_token');
//        session()->pull('uid');
        header('location:/login');
    }



    /**
     *  搜索
     */
    public function searchShow()
    {
        echo 1122221;
    }

}
