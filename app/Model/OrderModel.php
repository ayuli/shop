<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    //
    public $table = 'p_order';
    public $timestamps = false;

    /**
     * 生成订单号
     */
    public static function OrderSN()
    {
//        return date('ymdHi').rand(11111,99999).rand(2222,8888);
        return date('YmdH').rand(111,999).rand(222,888);
    }

}
