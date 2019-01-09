@extends('layouts.bst')

@section('content')
        <h1>购物车</h1>
        <table class="table table-hover">
            <thead>
            <td>ID</td><td>GOODS_ID</td><td>NUM</td><td>TIME</td><td>UID</td><td></td>
            </thead>
            <tbody>
            @foreach($cart as $v)
                <tr>
                    <td>{{$v['id']}}</td><td>{{$v['goods_id']}}</td><td>{{$v['num']}}</td><td>{{$v['add_time']}}</td><td>{{$v['uid']}}</td>
                    <td><button type="button" class="btn btn-primary" cart_id="{{$v['id']}}">删除</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
@endsection

@section('footer')
    @parent
    <script src="{{URL::asset('/js/goods/goodsDel.js')}}"></script>
@endsection



