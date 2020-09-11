<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <link href="{{asset('./system/css/base.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>{{$message}}</h3>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <table class="table tb-type2 msg">
        <tbody class="noborder">
        <tr>
            <td rowspan="5" class="msgbg"></td>

        </tr>

        <tr>
            <td class="tip2">正在跳转</td>
        </tr>
        <tr>
            <td>
                @empty($url)
                    <a href="javascript:history.back()" class="btns"><span>上一步</span></a>
                    <script type="text/javascript"> window.setTimeout("javascript:history.back()", 3000); </script>
                @else
                    <a href="{{$url}}" class="btns"><span>上一步</span></a>
                    <script type="text/javascript"> window.setTimeout("javascript:location.href='{{$url}}'",3000); </script>
                @endempty
            </td>
        </tr>

        </tbody>
    </table>
</div>
</body>
</html>