@extends('layouts.bst')

@section('content')
    <div class="container">
        <h2>开聊... openid:{{$openid}}</h2>

        <div class="chat" id="chat_div">

        </div>
        <hr>

        <form action="" class="form-inline">
            <input type="hidden" value="{{$openid}}" id="openid">
            <input type="hidden" value="1" id="msg_pos">
            <textarea name="" id="send_msg" cols="100" rows="5"></textarea>
            <button class="btn btn-info" id="send_msg_btn">Send</button>
        </form>
    </div>
@endsection
@section('footer')
    @parent
    <script>
        // alert(34234)
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
        $("#send_msg_btn").click(function(){
            var message = $("#send_msg").val();
            var msg_str = '<p style="color: mediumorchid"> >>>>> '+send_msg+'</p>';
            $("#chat_div").append(msg_str);
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
{{--    <script src="{{URL::asset('/js/weixin/chat.js')}}"></script>--}}
@endsection