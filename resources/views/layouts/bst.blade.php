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
                    <li class="hidden-sm hidden-md"><a href=""  onclick="_hmt.push(['_trackEvent', 'navbar', 'click', 'v2doc'])">Bootstrap2中文文档</a></li>
                    <li><a href="/goods"  >Bootstrap商品表</a></li>
                    <li><a class="reddot" href="/order" >订单表</a></li>
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </ul>
                <ul class="nav navbar-nav navbar-right hidden-sm">
                    <li><a href="/cart" >购物车</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right hidden-sm">
                    <li><a href="/user/login" >登陆</a></li>
                    <li><a href="/user/reg" >注册</a></li>
                    <li><a href="/user/quit" >退出</a></li>
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