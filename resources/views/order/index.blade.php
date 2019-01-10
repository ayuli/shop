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
                    <td>{{date('Y-m-d H:i:s',$v['add_time'])}}</td>
                    <td>{{$v['order_amount']}}</td>
                    <td>
                        @if($v['is_pay']==1)
                        <a type="button" class="btn btn-info" href="/order/pay/{{$v['order_id']}}" id="add_cart_btn">支付</a>
                        <a type="button" class="btn btn-info" href="/order/off/{{$v['order_id']}}" id="add_cart_btn">取消订单</a>
                        @elseif($v['is_pay']==2)
                            <button type="button" class="btn btn-default" disabled="disabled">已支付</button>
                            <a type="button" class="btn btn-info" href="/order/pay/{{$v['order_id']}}" id="add_cart_btn">退款</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <nav aria-label="...">
            <ul class="pager">
                <li><a href="#">Previous</a></li>
                <li><a href="#">Next</a></li>
            </ul>
        </nav>

@endsection

@section('footer')
    @parent
    <script src="{{URL::asset('/js/order/pay.js')}}"></script>
@endsection



