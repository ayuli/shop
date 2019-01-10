@extends('layouts.bst')

@section('content')
        <h1>订单展示</h1>
        <table class="table table-hover">
            <thead>
                <td>订单ID</td>
                <td>订单号</td>
                <td>商品ID</td>
                <td>购买数量</td>
                <td>用户</td><td>时间</td><td>总价</td><td></td>
            </thead>
            <tbody>
            @foreach($order as $v)
                <tr>
                    <td>{{$v['order_id']}}</td>
                    <td>{{$v['order_sn']}}</td>
                    <td>{{$v['goods_id']}}</td>
                    <td>{{$v['pay_num']}}</td>
                    <td>{{$v['uid']}}</td>
                    <td>{{$v['add_time']}}</td><td>{{$v['order_amount']}}</td>
                    <td><button type="button" class="btn btn-primary" order="{{$v['order_id']}}" id="add_cart_btn">支付</button>
                        <button type="button" class="btn btn-primary" order="{{$v['order_id']}}" id="add_cart_btn">取消订单</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection

@section('footer')
    @parent
    <script src="{{URL::asset('/js/order/pay.js')}}"></script>
@endsection



