<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
    <title>QRCode</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
    <script src="{{URL::asset('/qrcode/qrcode.js')}}"></script>
</head>
<body>
<div id="qrcode" align="center"></div>

<script type="text/javascript">

    // 设置参数方式
    var qrcode = new QRCode('qrcode', {
        text: 'your content',
        width: 300,
        height: 300,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });

    // 使用 API
    qrcode.clear();
    qrcode.makeCode("{{$url}}");
</script>
</body>
</html>
