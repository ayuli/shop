@extends('layouts.bst')

@section('content')
    <form action="/goods/upload/pdf" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" name="pdf">
        <input type="submit" value="提交">
    </form>

@endsection

@section('footer')
    @parent

@endsection