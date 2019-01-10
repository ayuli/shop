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
                <td>商品ID</td>
                <td>{{$order['goods_id']}}</td>
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
        <div style="margin-left: 1000px;">
            <a type="button" href="/order/payo/{{$order['order_id']}}" class="btn btn-warning btn-lg ">支付</a>
        </div>


@endsection

@section('footer')
    @parent
    <script src="{{URL::asset('/js/order/pay.js')}}"></script>
@endsection



