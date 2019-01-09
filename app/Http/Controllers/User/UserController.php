<?php

namespace App\Http\Controllers\User;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\UserModel;

class UserController extends Controller
{
    /**
     * 用户注册
     * 2019年1月3日14:26:56
     * liwei
     */
    public function reg()
    {
        return view('users.reg');
    }

    public function doReg(Request $request)
    {
        echo __METHOD__;
        echo '<pre>';print_r($_POST);echo '</pre>';
        $pass = $request->input('pass');
        $pass2 = $request->input('pass2');
        $username = $request->input('username');
        //验证用户唯一
        $uniqueness = UserModel::where(['nick_name'=>$username])->first();
        if($uniqueness){
            die("用户已存在");
        }
        if($pass !== $pass2){
            die("密码不一致");
        }
        $pass = password_hash($pass,PASSWORD_BCRYPT);
        $data = [
            'nick_name'  => $request->input('username'),
            'pass'  => $pass,
            'age'  => $request->input('age'),
            'tel'  => $request->input('tel'),
            'reg_time' => time()
        ];

        $uid = UserModel::insertGetId($data);
        var_dump($uid);

        if($uid){
            header('refresh:2;url=/user/center');
            setcookie('uid',$uid,time()+86400,'/','shop.com',false,true);
            $request->session()->put('uid',$uid);
            echo '注册成功';
        }else{
            echo '注册失败';
        }
    }
    /** 用户登陆 */
    public function login()
    {
        return view('users.login');
    }

    public function doLogin(Request $request)
    {
        $username = $request->input('username');
        $pass = $request->input('pass');

        $we = UserModel::where(['nick_name'=>$username])->first();
        //相当于验证密码
        $re = password_verify($pass,$we['pass']);

        if($we){
            if($re){
                $token = substr(md5(time().mt_rand(1,99999)),10,10);
                setcookie('uid',$we->uid,time()+86400,'/','shop.com',false,true);
                setcookie('token',$token,time()+86400,'/user','',false,true);

                $request->session()->put('u_token',$token);
                $request->session()->put('uid',$we->uid);

                header('refresh:2;url=/user/center');
                echo "登录成功";
            }else{
                die("密码不正确");
            }
        }else{
            die("用户不存在");
        }

    }

    public function center(Request $request)
    {

        if($_COOKIE['token'] != $request->session()->get('u_token')){
            die("非法请求");
        }else{
            echo '正常请求';
        }


        echo 'u_token: '.$request->session()->get('u_token'); echo '</br>';
//        echo '<pre>';print_r($request->session()->get('u_token'));echo '</pre>';

//        echo '<pre>';print_r($_COOKIE);echo '</pre>';

        if(empty($_COOKIE['uid'])){
            header('Refresh:2;url=/user/login');
            echo '请先登录';
            exit;
        }else{
            echo 'UID: '.$_COOKIE['uid'] . ' 欢迎回来';
            $list = UserModel::all();
            $data = [
                'list'=>$list,
                'title'=>'UID: '.$_COOKIE['uid'] . ' 欢迎回来'
            ];
            return view('users.show',$data);
        }
    }

}
