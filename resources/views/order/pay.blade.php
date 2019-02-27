@extends('layouts.bst')

@section('content')
        <h1>支付</h1>
        <table class="table table-hover">
            <tr>
                <td>订单ID</td>
                <td>{{$order['order_id']}}</td>
            </tr>
            <tr>
                <td>订单号</td>
                <td>{{$order['order_sn']}}</td>
            </tr>
            <tr>
                <td>商品名称</td>
                <td>{{$goods['goods_name']}}</td>
            </tr>
            <tr>
                <td>购买数量</td>
                <td>{{$order['pay_num']}}</td>
            </tr>
            <tr>
                <td>时间</td>
                <td>{{date('Y-m-d H:i:s',$order['add_time'])}}</td>
            </tr>
            <tr>
                <td>总价</td>
                <td>{{$order['order_amount']}}</td>
            </tr>
        </table>
        <div >
            @if($order['is_pay']==1)
                <a type="button" class="btn btn-info" href="/alipay/payo/{{$order['order_id']}}" id="add_cart_btn">支付宝支付</a>
                <a type="button" class="btn btn-info" href="/weixin/pay/test/{{$order['order_id']}}" id="add_cart_btn">微信支付</a>
                <a type="button" class="btn btn-info" href="/order/off/{{$order['order_id']}}" id="add_cart_btn">取消订单</a>
            @elseif($order['is_pay']==2)
                <button type="button" class="btn btn-default" disabled="disabled">已支付</button>
                <a type="button" class="btn btn-info" href="/order/refund/{{$order['order_id']}}" id="add_cart_btn">退款</a>
            @elseif($order['is_pay']==3)
                <button type="button" class="btn btn-default" disabled="disabled">已退款</button>
            @endif
        </div>


@endsection

@section('footer')
    @parent
@endsection



