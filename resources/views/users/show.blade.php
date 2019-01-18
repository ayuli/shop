{{-- 用户注册--}}

@extends('layouts.bst')

@section('content')


    <div class="jumbotron">
        <h1></h1>
        <p>以下是所有用户</p>
    </div>

    <table class="table table-bordered">
            <thead>
                <td>ID</td><td>name</td><td>age</td><td>email</td><td>created_at</td>
            </thead>
            <tbody>
            @foreach($list as $v)
                <tr>
                    <td>{{$v['id']}}</td><td>{{$v['name']}}</td><td>{{$v['email']}}</td><td>{{$v['created_at']}}</td><td>{{$v['reg_time']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
@endsection