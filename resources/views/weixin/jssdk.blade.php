@extends('layouts.bst')

@section('content')
   <div class="container">
       <h2>JS-SDK</h2>
       <button id="btn1">上传图片</button>
   </div>
@endsection
@section('footer')
    @parent

    <script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>

    <script>
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: "{{$jsconfig['appid']}}", // 必填，公众号的唯一标识
            timestamp:{{$jsconfig['timestamp']}}, // 必填，生成签名的时间戳
            nonceStr: "{{$jsconfig['noncestr']}}", // 必填，生成签名的随机串
            signature: "{{$jsconfig['sign']}}",// 必填，签名
            jsApiList: ['chooseImage','uploadImage','getLocalImgData','startRecord'] // 必填，需要使用的JS接口列表
        });

        wx.ready(function(){
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。

            $("#btn1").click(function () {
                //拍照或从手机相册中选图接口
                wx.chooseImage({
                    count: 9, // 默认9
                    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (res) {
                        var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    }
                });

            });


        });

    </script>
@endsection