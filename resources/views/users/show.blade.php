{{-- 用户注册--}}

@extends('layouts.bst')

@section('content')


    <div class="jumbotron">
        <h1>{{$title}}</h1>
        <p>以下是所有用户</p>
    </div>

    <table class="table table-bordered">
            <thead>
                <td>ID</td><td>nick_name</td><td>age</td><td>tel</td><td>reg_time</td>
            </thead>
            <tbody>
            @foreach($list as $v)
                <tr>
                    <td>{{$v['uid']}}</td><td>{{$v['nick_name']}}</td><td>{{$v['age']}}</td><td>{{$v['tel']}}</td><td>{{$v['reg_time']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
@endsection