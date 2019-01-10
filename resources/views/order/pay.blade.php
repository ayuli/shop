@extends('layouts.bst')

@section('content')
        <h1>支付</h1>
        <table class="table table-hover">
            <thead>
                <td>订单ID</td>
                <td>订单号</td>
                <td>商品ID</td>
                <td>购买数量</td>
                <td>用户</td><td>时间</td><td>总价</td>
            </thead>
            <tbody>
                <tr>
                    <td>{{$order['order_id']}}</td>
                    <td>{{$order['order_sn']}}</td>
                    <td>{{$order['goods_id']}}</td>
                    <td>{{$order['pay_num']}}</td>
                    <td>{{$order['uid']}}</td>
                    <td>{{$order['add_time']}}</td><td>{{$order['order_amount']}}</td>
                </tr>
            </tbody>
        </table>
        <div style="margin-left: 1000px;">
            <a type="button" class="btn btn-warning btn-lg ">支付</a>
        </div>


@endsection

@section('footer')
    @parent
    <script src="{{URL::asset('/js/order/pay.js')}}"></script>
@endsection



