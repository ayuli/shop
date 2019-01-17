<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    //
    public $primaryKey = 'goods_id';
    public $table = 'p_goods';
    public $timestamps = true;
    public $updated_at = false;
}
