@extends('layouts.bst')

@section('content')
    <div class="container" style="width: 800px">
        <h2>
            <img src="{{$user['headimgurl']}}" alt="头像" width="52px" class="img-rounded" style="margin-left: 100px">
            &nbsp;&nbsp;{{$user['nickname']}}
        </h2>
        <input type="hidden" value="{{$user['nickname']}}" id="nickname">
        <div class="chat" id="chat_div">

        </div>
        <hr>

        <form action="" class="form-inline">
            <input type="hidden" value="{{$user['openid']}}" id="openid">
            <input type="hidden" value="1" id="msg_pos">
            <textarea name="" id="send_msg" cols="107" rows="5"></textarea><br><br>
            <button class="btn btn-info" id="send_msg_btn" style="float: right">Send Message</button>

        </form>
    </div>
@endsection
@section('footer')
    @parent
    <script>


        var openid = $("#openid").val();
        var nickname = $("#nickname").val();
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
                        if(d.data.msg_type==2){
                            //数据填充
                            var msg_str = '<p align="center">' + '客服&nbsp;&nbsp;'+ d.data.add_time + '</p>' +
                                '<blockquote>' + d.data.msg  + '</blockquote>';

                            $("#chat_div").append(msg_str);
                            $("#msg_pos").val(d.data.id)
                        }else{
                            //数据填充
                            var msg_str = '<p align="center">' + '用户&nbsp;&nbsp;'+ d.data.add_time + '</p>' +
                                '<blockquote>' + d.data.msg  + '</blockquote>';

                            $("#chat_div").append(msg_str);
                            $("#msg_pos").val(d.data.id)
                        }


                    }else{

                    }
                }
            });
        },5000);

        // 客服发送消息 begin
        $("#send_msg_btn").click(function(e){
            e.preventDefault();
            var message = $("#send_msg").val().trim();
            // var msg_str = '<p style="color: mediumorchid"> >>>>> '+message+'</p>';
            // $("#chat_div").append(msg_str);
            $("#send_msg").val("");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url     :       '/weixin/write',
                type    :       'post',
                data    :       {message:message,openid:openid},
                dataType:       'json',
                success :   function(d){
                    console.log(d);
                }
            })
        });
        // 客服发送消息 end
    </script>
    <script src="{{URL::asset('/js/weixin/chat.js')}}"></script>
@endsection