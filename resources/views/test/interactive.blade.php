<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Document</title>
    <link rel="stylesheet" href="{{URL::asset('/bootstrap/css/bootstrap.min.css')}}">
</head>
<body>
    <div class="chat" id="chat_div">

    </div>
    <hr>

    <form action="/weixin/write" method="post">
        {{csrf_field()}}
        <div style="width: 500px;margin: auto;margin-top: 60px;">
            <div class="form-group" style="margin-left: 90px">
                <label for="exampleInputEmail2">
                    <img src="{{$user['headimgurl']}}" alt="头像" width="100px" class="img-rounded" style="margin-left: 100px">
                </label>
                <input type="text" class="form-control" value="{{$user['nickname']}}" readonly style="width: 304px;">
                <input type="hidden" id="openid" value="{{$user['openid']}}" readonly>
                <input type="hidden" id="msg_pos" value="1" readonly>
            </div>

                <textarea class="form-control" id="textarea" cols="5" rows="10" readonly></textarea><br>

                <input type="text" class="form-control" id="message"><br>

                <button type="button" class="btn btn-default" id="commit" style="float: right">Send Message</button>
        </div>
    </form>
</body>
</html>
<script src="{{URL::asset('/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{URL::asset('/bootstrap/js/bootstrap.min.js')}}"></script>
{{--<script src="{{URL::asset('/js/interactive/interactive.js')}}"></script>--}}
<script>
    // $(function () {
    //     $("#commit").click(function (e) {
    //         e.preventDefault();
    //         var message = $("#message").val();
    //         var message_br = message+"<br>";
    //         $("#textarea").append(message_br);
    //         $("#message").val('');
    //
    //         var openid = $("#openid").val();
    //
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             url     :       '/weixin/write',
    //             type    :       'post',
    //             data    :       {message:message,openid:openid},
    //             dataType:       'json',
    //             success :   function(d){
    //                 console.log(d);
    //             }
    //         })
    //
    //
    //     })
    // })


    var openid = $("#openid").val();

    setInterval(function(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url     :   '/weixin/chat/get_msg?openid=' + openid + '&pos=' + $("#msg_pos").val(),
            type    :   'get',
            dataType:   'json',
            success :   function(d){
                if(d.errno==0){     //服务器响应正常
                    //数据填充
                    var msg_str = '<blockquote>' + d.data.created_at +
                        '<p>' + d.data.msg + '</p>' +
                        '</blockquote>';

                    $("#chat_div").append(msg_str);
                    $("#msg_pos").val(d.data.id)
                }else{

                }
            }
        });
    },5000);

    // 客服发送消息 begin
    $("#commit").click(function(e){
        e.preventDefault();
        var message = $("#message").val().trim();
        var msg_str = '<p style="color: mediumorchid"> >>>>> '+message+'</p>';
        $("#chat_div").append(msg_str);
        $("#message").val("");
    });
    // 客服发送消息 end

</script>
