<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>微信支付二维码</title>
    {{--<script src="{{URL::asset('/qrcode/qrcode.js')}}"></script>--}}
    {{--<script src="{{URL::asset('/js/jquery-3.2.1.min.js')}}"></script>--}}
    <script src="/qrcode/qrcode.js"></script>
    <script src="/js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div id="canvas" style="">

    </div>
</body>
</html>
<script>
    var qrcode = new QRCode('canvas', {
        text: "{{$url}}",
        width: 300,
        height: 300,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H,
    });


    setInterval(function(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url     :   '/weixin/pay/wx_uccess/{{$order_id}}',
            type    :   'get',
            dataType:   'json',
            success :   function(d){
                if(d.error==1){
                    alert('支付成功');
                    window.location.href='/order'
                }
            }
        });
    },5000);


</script>