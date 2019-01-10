@extends('layouts.bst')

@section('content')
        <h1>商品详情表</h1>
        <table class="table table-bordered">
            <thead>
            <td>GOODS_ID</td><td>NAME</td><td>PRICE</td><td>TIME</td><td>CAT_ID</td><td></td>
            </thead>
            <tbody>
            @foreach($goods as $v)
                <tr>
                    <td>{{$v['goods_id']}}</td>
                    <td>{{$v['goods_name']}}</td>
                    <td>{{$v['price']}}</td>
                    <td>{{date('Y-m-d H:i:s',$v['add_time'])}}</td>
                    <td>{{$v['cat_id']}}</td>
                    <td><a href="/cart/add/{{$v['goods_id']}}" class="btn btn-info">查看</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection
{{--@section('footer')--}}
    {{--@parent--}}
    {{--<script src="{{URL::asset('/js/goods/goods.js')}}"></script>--}}
{{--@endsection--}}





