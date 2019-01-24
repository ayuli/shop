@extends('layouts.bst')

@section('content')
    <div style="margin-top: 30px; width: 600px;">
    @foreach($seat as $k=>$v)
    @if($v==1)
            <a class="btn btn-danger" href="/movie/buy/{{$k}}/{{$v}}" style="width: 70px;margin-top: 10px;">座位{{ $k+1 }}</a>
    @else
            <a class="btn btn-info" href="/movie/buy/{{$k}}/{{$v}}" style="width: 70px;margin-top: 10px;">座位{{ $k+1 }}</a>
    @endif

    @endforeach
    </div>
@endsection

@section('footer')
{{--    <script src="{{URL::asset('/js/movie/movie.js')}}"></script>--}}
@endsection




