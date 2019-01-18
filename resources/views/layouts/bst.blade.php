<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>BootStrap-@yield('title')</title>
    <link rel="stylesheet" href="{{URL::asset('/bootstrap/css/bootstrap.min.css')}}">
</head>
<body>

<div class="container">

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-sm" href="/user/center" >Bootstrap首页</a>
            </div>
            <div class="navbar-collapse collapse" role="navigation">
                <ul class="nav navbar-nav">
                    <li class="hidden-sm hidden-md"><a href="">Bootstrap2</a></li>
                    <li><a href="/goods"  >Bootstrap商品表</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right hidden-sm">
                    <li><a href="/cart" >购物车</a></li>
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true">个人中心</span> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">个人资料</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a class="reddot" href="/order" >我的订单</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="/user/quit" >退出</a></li>
                        </ul>
                        </li>
                </ul>
            </div>
        </div>
    </div>
    <div style="margin-top: 80px;"></div>


    @yield('content')


</div>

@section('footer')
    <script src="{{URL::asset('/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{URL::asset('/bootstrap/js/bootstrap.min.js')}}"></script>
@show
</body>
</html>