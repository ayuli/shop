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
                    <td>{{$v['order_id']}}</td>
                    <td>{{$v['order_sn']}}</td>
                    <td>{{$v['goods_id']}}</td>
                    <td>{{$v['pay_num']}}</td>
                    <td>{{$v['uid']}}</td>
                    <td>{{$v['add_time']}}</td><td>{{$v['order_amount']}}</td>
                </tr>
            </tbody>
        </table>

@endsection

@section('footer')
    @parent
    <script src="{{URL::asset('/js/order/pay.js')}}"></script>
@endsection



